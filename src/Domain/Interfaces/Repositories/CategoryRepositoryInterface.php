<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Query\Entities\Query;

interface CategoryRepositoryInterface extends CrudRepositoryInterface
{

    public function findOneByName(string $name, Query $query = null): CategoryEntity;
}
