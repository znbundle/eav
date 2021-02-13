<?php

namespace ZnBundle\Eav\Domain\Entities;

use InvalidArgumentException;

class DynamicEntity extends \ZnCore\Domain\Entities\DynamicEntity
{

    protected $id;

    public function __construct(EntityEntity $entityEntity = null, array $attributes = [])
    {
        /** @var EntityEntity $entityEntity */
        parent::__construct($entityEntity, $attributes);
        if (empty($this->_attributes)) {
            throw new InvalidArgumentException('No attributes for dynamic entity!');
        }
    }

    public function __set(string $attribute, $value)
    {
        $this->checkHasAttribute($attribute);
        $this->{$attribute} = $value;
    }
}
