<?php

namespace ZnBundle\Eav\Domain\Services;

use DateTime;
use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\ValueServiceInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnCore\Base\Libs\Query\Entities\Query;

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
        $valueCollection = $this->getRepository()->allValues($entityId, $recordId);
        if($valueCollection->count() == 0) {
            throw new NotFoundException();
        }
        $dynamicEntity = $this->entityService->createEntityById($entityId);
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
