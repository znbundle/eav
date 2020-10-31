<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
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

}
