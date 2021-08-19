<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnCore\Domain\Libs\Query;

interface CategoryRepositoryInterface extends CrudRepositoryInterface
{

    public function oneByName(string $name, Query $query = null): CategoryEntity;
}
