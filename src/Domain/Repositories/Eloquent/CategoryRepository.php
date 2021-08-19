<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class CategoryRepository extends BaseEloquentCrudRepository implements CategoryRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_category';
    }

    public function getEntityClass(): string
    {
        return CategoryEntity::class;
    }

    public function oneByName(string $name, Query $query = null): CategoryEntity
    {
        $query = Query::forge($query);
        $query->where('name', $name);
        return $this->one($query);
    }
}
