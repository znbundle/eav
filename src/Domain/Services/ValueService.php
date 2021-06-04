<?php

namespace ZnBundle\Eav\Domain\Services;

use DateTime;
use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\ValueServiceInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnCore\Domain\Libs\Query;

/**
 * @method ValueRepositoryInterface getRepository()
 */
class ValueService extends BaseCrudService implements ValueServiceInterface
{

    private $entityService;

    public function __construct(EntityManagerInterface $em, EntityServiceInterface $entityService)
    {
        $this->setEntityManager($em);
        $this->entityService = $entityService;
    }

    public function getEntityClass() : string
    {
        return ValueEntity::class;
    }

    public function oneRecord(int $entityId, int $recordId): DynamicEntity
    {
        $dynamicEntity = $this->entityService->createEntityById($entityId);
        $query = new Query();
        $query->where('record_id', $recordId);
        $query->with(['attribute']);
        /** @var ValueEntity[] | Collection $valueCollection */
        $valueCollection = $this->getRepository()->all($query);
        if($valueCollection->count() == 0) {
            throw new NotFoundException();
        }
        foreach ($valueCollection as $valueEntity) {
            $name = $valueEntity->getAttribute()->getName();
            EntityHelper::setAttribute($dynamicEntity, $name, $valueEntity->getValue());
        }
        return $dynamicEntity;
    }

    public function persistValue(AttributeEntity $attributeEntity, int $entityId, int $recordId, $value): void
    {
        $valueEntity = new ValueEntity();
        $valueEntity->setEntityId($entityId);
        $valueEntity->setRecordId($recordId);
        $valueEntity->setAttributeId($attributeEntity->getId());
        $valueEntity->setValue($value);
        $valueEntity->setUpdatedAt(new DateTime());
        $this->getEntityManager()->persist($valueEntity);
    }
}
