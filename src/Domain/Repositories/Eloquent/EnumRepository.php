<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Entities\EnumEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnCore\Domain\Libs\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class EnumRepository extends BaseEloquentCrudRepository implements EnumRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_enum';
    }

    public function getEntityClass(): string
    {
        return EnumEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        return parent::forgeQuery($query)->orderBy(['sort' => SORT_ASC]);
    }
}

