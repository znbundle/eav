<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\ValueEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Relation\Libs\Types\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class ValueRepository extends BaseEloquentCrudRepository implements ValueRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_value';
    }

    public function getEntityClass(): string
    {
        return ValueEntity::class;
    }

    public function relations()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'attribute_id',
                'relationEntityAttribute' => 'attribute',
                'foreignRepositoryClass' => AttributeRepositoryInterface::class,
            ],
        ];
    }

    public function allValues(int $entityId, int $recordId, Query $query = null): Collection
    {
        $query = Query::forge($query);
        $query->where('entity_id', $entityId);
        $query->where('record_id', $recordId);
        $query->with(['attribute']);
        return $this->findAll($query);
    }
}
