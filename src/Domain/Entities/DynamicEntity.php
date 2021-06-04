<?php

namespace ZnBundle\Eav\Domain\Entities;

use InvalidArgumentException;
use ZnBundle\Eav\Domain\Traits\DynamicAttribute;
use ZnCore\Domain\Interfaces\Entity\EntityAttributesInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class DynamicEntity implements ValidateEntityInterface, EntityIdInterface, EntityAttributesInterface
{

    use DynamicAttribute;

    protected $id;
//    protected $_attributes = [];
    protected $_validationRules = [];

    public function __construct(EntityEntity $entityEntity)
    {
        if ($entityEntity) {
            $this->_attributes = $entityEntity->getAttributeNames();
            $this->_validationRules = $entityEntity->getRules();
        }
        if (empty($this->_attributes)) {
            throw new InvalidArgumentException('No attributes for dynamic entity!');
        }
    }

    /*public function __set(string $attribute, $value)
    {
        $attribute = Inflector::variablize($attribute);
        $this->checkHasAttribute($attribute);
        $this->{$attribute} = $value;
    }

    public function __get(string $attribute)
    {
        $attribute = Inflector::variablize($attribute);
        $this->checkHasAttribute($attribute);
        return $this->{$attribute} ?? null;
    }

    public function __call(string $name, array $arguments)
    {
        $method = substr($name, 0, 3);
        $attributeName = substr($name, 3);
        $attributeName = lcfirst($attributeName);
        if ($method == 'get') {
            return $this->__get($attributeName);
        } elseif ($method == 'set') {
            $this->__set($attributeName, $arguments[0]);
            return $this;
        }
        return null;
    }

    public function attributes(): array
    {
        return $this->_attributes;
    }

    private function checkHasAttribute(string $attribute)
    {
        $has = in_array($attribute, $this->_attributes);
        if (!$has) {
            throw new Exception('Not found attribute "' . $attribute . '"!');
        }
    }
    */

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
