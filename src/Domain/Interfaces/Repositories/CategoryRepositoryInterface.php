<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;

interface CategoryRepositoryInterface extends CrudRepositoryInterface
{

    public function oneByName(string $name, Query $query = null): CategoryEntity;
}
