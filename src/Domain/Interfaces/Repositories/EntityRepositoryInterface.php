<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Query\Entities\Query;

interface EntityRepositoryInterface extends CrudRepositoryInterface
{

    public function findOneByName(string $name, Query $query = null): EntityEntity;
}
