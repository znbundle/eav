<?php

namespace ZnBundle\Eav\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;

interface ValueRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $entityId
     * @param int $recordId
     * @param Query|null $query
     * @return Collection | ValueEntity[]
     */
    public function allValues(int $entityId, int $recordId, Query $query = null): Collection;
}
