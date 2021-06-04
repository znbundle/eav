<?php

namespace ZnBundle\Eav\Domain\Services;

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

    public function __construct(
        EntityRepositoryInterface $repository,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->setRepository($repository);
        $this->attributeRepository = $attributeRepository;
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

    public function validate(int $entityId, array $data): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        //$dynamicEntity = $this->createEntityById($entityId);
        $data = $this->normalizeData($data, $entityEntity);

        EntityHelper::setAttributes($dynamicEntity, $data);
        //dd($entityEntity);
        $this->validateEntity($dynamicEntity);
        return $dynamicEntity;
    }

    public function normalize(int $entityId, array $data = []): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        $data = $this->normalizeData($data, $entityEntity);
        EntityHelper::setAttributes($dynamicEntity, $data);
        //$this->validateEntity($dynamicEntity);
        return $dynamicEntity;
    }
    
    private function normalizeData(array $data, EntityEntity $entityEntity)
    {
        foreach ($entityEntity->getAttributes() as $attributeEntity) {
            $attributeName = $attributeEntity->getName();
            $default = $attributeEntity->getDefault();
            $type = $attributeEntity->getType();
            $value = $data[$attributeName] ?? null;
            if ($default !== null && $value === null) {
                $value = $default;
            }
            $value = $this->typeCast($value, $type);
            $data[$attributeName] = $value;
        }
        return $data;
    }

    private function typeCast($value, string $type)
    {
        if ($value !== null) {
            if ($type == 'boolean' || $type == 'bool') {
                $value = boolval($value);
            } elseif ($type == 'int' || $type == 'integer') {
                $value = intval($value);
            }
        }
        return $value;
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
