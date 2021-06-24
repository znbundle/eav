<?php

namespace ZnBundle\Eav\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Forms\DynamicForm;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnCore\Domain\Libs\Query;

interface EntityServiceInterface extends CrudServiceInterface
{

    public function allByCategoryId(int $categoryId, Query $query = null): Collection;

    public function oneByName(string $name, Query $query = null): EntityEntity;

    public function validateEntity(DynamicEntity $dynamicEntity): void;

    public function updateEntity(DynamicEntity $dynamicEntity): void;

    public function createEntityById(int $id): DynamicEntity;

    public function createFormById(int $id): DynamicForm;

    public function oneByIdWithRelations($id, Query $query = null): EntityEntity;

    /**
     * @param int $entityId
     * @param array $data
     * @return DynamicEntity
     * @throws UnprocessibleEntityException
     */
    public function validate(int $entityId, array $data): DynamicEntity;
}
