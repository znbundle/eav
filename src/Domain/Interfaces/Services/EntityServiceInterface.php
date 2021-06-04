<?php

namespace ZnBundle\Eav\Domain\Interfaces\Services;

use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnCore\Domain\Libs\Query;

interface EntityServiceInterface extends CrudServiceInterface
{

    public function oneByIdWithRelations($id, Query $query = null): EntityEntity;

    /**
     * @param int $entityId
     * @param array $data
     * @return DynamicEntity
     * @throws UnprocessibleEntityException
     */
    public function validate(int $entityId, array $data): DynamicEntity;
}
