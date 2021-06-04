<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class ValueRepository extends BaseEloquentCrudRepository implements ValueRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_value';
    }

    public function getEntityClass(): string
    {
        return ValueEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'attribute_id',
                'relationEntityAttribute' => 'attribute',
                'foreignRepositoryClass' => AttributeRepositoryInterface::class,
            ],
        ];
    }
}
