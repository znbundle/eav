<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;

interface EntityRepositoryInterface extends CrudRepositoryInterface
{

    public function findOneByName(string $name, Query $query = null): EntityEntity;
}
