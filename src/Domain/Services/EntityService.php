<?php

namespace ZnBundle\Eav\Domain\Services;

use Symfony\Component\PropertyAccess\PropertyAccess;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EntityRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Libs\Query;

class EntityService extends BaseCrudService implements EntityServiceInterface
{

    private $attributeRepository;

    //private $formFactory;

    public function __construct(
        EntityRepositoryInterface $repository,
        AttributeRepositoryInterface $attributeRepository
        //FormFactoryInterface $formFactory
    )
    {
        $this->setRepository($repository);
        $this->attributeRepository = $attributeRepository;
        //$this->formFactory = $formFactory;
    }

    public function oneByIdWithRelations($id, Query $query = null): EntityEntity
    {
        $query = Query::forge($query);
        $query->with([
            'attributesTie.attribute',
            //'attributesTie.attribute.enums',
            //'attributesTie.attribute.unit',
        ]);
        /** @var EntityEntity $entity */
        $entity = parent::oneById($id, $query);
        return $entity;
    }

    public function createEntityById(int $id): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($id);
        return new DynamicEntity($entityEntity);
    }

    /**
     * @param int $entityId
     * @param array $data
     * @return object
     * @throws UnprocessibleEntityException
     */
    public function validate(int $entityId, array $data): object
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        //$dynamicEntity = $this->createEntityById($entityId);
        EntityHelper::setAttributes($dynamicEntity, $data);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($entityEntity->getAttributes() as $attributeEntity) {
            $value = $propertyAccessor->getValue($dynamicEntity, $attributeEntity->getName());
            if ($attributeEntity->getDefault() !== null && $value === null) {
                $propertyAccessor->setValue($dynamicEntity, $attributeEntity->getName(), $attributeEntity->getDefault());
            }
        }
        $this->validateEntity($dynamicEntity);
        return $dynamicEntity;
    }

    private function validateEntity($dynamicEntity)
    {
        $violations = ValidationHelper::validate2222($dynamicEntity);
        $errorCollection = ValidationHelper::createErrorCollectionFromViolationList($violations);
        if ($errorCollection->count()) {
            $exception = new UnprocessibleEntityException;
            $exception->setErrorCollection($errorCollection);
            throw $exception;
        }
    }
}
