<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;

interface EntityRepositoryInterface extends CrudRepositoryInterface
{

    public function oneByName(string $name, Query $query = null): EntityEntity;
}
