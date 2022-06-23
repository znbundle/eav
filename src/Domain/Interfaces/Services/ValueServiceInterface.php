<?php

namespace ZnBundle\Eav\Domain\Interfaces\Services;

use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Service\Interfaces\CrudServiceInterface;

interface ValueServiceInterface extends CrudServiceInterface
{

    /**
     * @param AttributeEntity $attributeEntity
     * @param int $typeId
     * @param int $recordId
     * @param $value
     * @return void
     * @var UnprocessibleEntityException
     */
    public function persistValue(AttributeEntity $attributeEntity, int $typeId, int $recordId, $value): void;

    /**
     * @param int $entityId
     * @param int $recordId
     * @return DynamicEntity
     * @throws NotFoundException
     */
    public function oneRecord(int $entityId, int $recordId): DynamicEntity;
}
