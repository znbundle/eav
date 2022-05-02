<?php

namespace ZnBundle\Eav\Domain\Entities;

use InvalidArgumentException;
use ZnBundle\Eav\Domain\Libs\Rules;
use ZnBundle\Eav\Domain\Traits\DynamicAttribute;
use ZnCore\Domain\Interfaces\Entity\EntityAttributesInterface;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class DynamicEntity implements ValidateEntityInterface, EntityIdInterface, EntityAttributesInterface
{

    use DynamicAttribute;

    protected $id;
    protected $_validationRules = [];
    protected $_entity;

    public function __construct(EntityEntity $entityEntity)
    {
        if ($entityEntity) {
            $this->_attributes = $entityEntity->getAttributeNames();
            $this->_entity = $entityEntity;
            $rulesLib = new Rules();
            $this->_validationRules = $rulesLib->convert($entityEntity->getAttributes());
        }
        if (empty($this->_attributes)) {
            throw new InvalidArgumentException('No attributes for dynamic entity!');
        }
    }

    public function entity(): EntityEntity
    {
        return $this->_entity;
    }

    public function entityId(): int
    {
        return $this->_entity->getId();
    }

    public function validationRules(): array
    {
        return $this->_validationRules;
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }
}
