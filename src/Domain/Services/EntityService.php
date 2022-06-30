<?php

namespace ZnBundle\Eav\Domain\Services;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Forms\DynamicForm;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EntityRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\ValueServiceInterface;
use ZnBundle\Eav\Domain\Libs\TypeNormalizer;
use ZnBundle\Eav\Domain\Libs\Validator;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnCore\Base\Container\Helpers\ContainerHelper;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\Query\Entities\Query;

class EntityService extends BaseCrudService implements EntityServiceInterface
{

    private $attributeRepository;

    public function __construct(
        EntityRepositoryInterface $repository,
        EntityManagerInterface $entityManager,
        AttributeRepositoryInterface $attributeRepository
        //ValueServiceInterface $valueService
    )
    {
        $this->setEntityManager($entityManager);
        $this->setRepository($repository);
        $this->attributeRepository = $attributeRepository;
        //$this->valueService = $valueService;
    }

    public function allByCategoryId(int $categoryId, Query $query = null): Collection
    {
        $query = Query::forge($query);
        $query->where('category_id', $categoryId);
        return $this->findAll($query);
    }

    public function findOneByName(string $name, Query $query = null): EntityEntity
    {
        return $this->getRepository()->findOneByName($name, $query);
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
        $entity = parent::findOneById($id, $query);
        return $entity;
    }

    public function createEntityById(int $id): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($id);
        return new DynamicEntity($entityEntity);
    }

    public function createFormById(int $id): DynamicForm
    {
        $entityEntity = $this->oneByIdWithRelations($id);
        return $this->createFormByEntity($entityEntity);
    }

    public function createFormByEntity(EntityEntity $entityEntity): DynamicForm
    {
        return new DynamicForm($entityEntity);
    }

    public function validateEntity(DynamicEntity $dynamicEntity): void
    {
        $this->validate($dynamicEntity->entityId(), $dynamicEntity->toArray());
    }

    public function updateEntity(DynamicEntity $dynamicEntity): void
    {
//        $recordId = $dynamicEntity->getId();
//        $this->validate($dynamicEntity->entityId(), $dynamicEntity->toArray());
        $this->validateEntity($dynamicEntity);
        $entityEntity = $this->oneByIdWithRelations($dynamicEntity->entityId());
        /** @var ValueServiceInterface $valueService */
        $valueService = ContainerHelper::getContainer()->get(ValueServiceInterface::class);
        foreach ($entityEntity->getAttributes() as $attributeEntity) {
            $name = $attributeEntity->getName();
            $value = EntityHelper::getValue($dynamicEntity, $name);
            $valueService->persistValue($attributeEntity, $dynamicEntity->entityId(), $dynamicEntity->getId(), $value);
        }
    }

    public function validate(int $entityId, array $data): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        //$dynamicEntity = $this->createEntityById($entityId);
        $normalizer = new TypeNormalizer();
        $data = $normalizer->normalizeData($data, $entityEntity);
        EntityHelper::setAttributes($dynamicEntity, $data);
        $validator = new Validator();
        $validator->validate($data, $dynamicEntity->validationRules());
        return $dynamicEntity;
    }

    public function normalize(int $entityId, array $data = []): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        $normalizer = new TypeNormalizer();
        $data = $normalizer->normalizeData($data, $entityEntity);
        EntityHelper::setAttributes($dynamicEntity, $data);
        //$this->validateEntity($dynamicEntity);
        return $dynamicEntity;
    }
}
