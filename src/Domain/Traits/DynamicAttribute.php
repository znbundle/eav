<?php

namespace ZnBundle\Eav\Domain\Traits;

use Exception;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\ArrayTools\Helpers\Collection;

trait DynamicAttribute
{

    protected $_attributes = [];

    public function __set(string $attribute, $value)
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

    protected function checkHasAttribute(string $attribute)
    {
        $has = in_array($attribute, $this->_attributes);
        if (!$has) {
            throw new Exception('Not found attribute "' . $attribute . '"!');
        }
    }

    public function toArray(): array
    {
        $values = [];
        foreach ($this->_attributes as $name) {
            $values[$name] = $this->__get($name);
        }
        return $values;
    }
}
