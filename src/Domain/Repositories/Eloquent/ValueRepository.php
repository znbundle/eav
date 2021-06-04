<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValueRepositoryInterface;

class ValueRepository extends BaseEloquentCrudRepository implements ValueRepositoryInterface
{

    public function tableName() : string
    {
        return 'eav_value';
    }

    public function getEntityClass() : string
    {
        return ValueEntity::class;
    }


}

