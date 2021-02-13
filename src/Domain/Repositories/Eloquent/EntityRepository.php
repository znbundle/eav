<?php

namespace ZnBundle\Eav\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnBundle\Eav\Domain\Entities\EntityAttributeEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EntityRepositoryInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class EntityRepository extends BaseEloquentCrudRepository implements EntityRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_entity';
    }

    public function getEntityClass(): string
    {
        return EntityEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'name' => 'attributesTie',
                'relationEntityAttribute' => 'attributes',
                'foreignRepositoryClass' => EntityAttributeRepositoryInterface::class,
                'foreignAttribute' => 'entity_id',
                'prepareCollection' => function (Collection $collection) {
                    /** @var EntityEntity $entityEntity */
                    foreach ($collection as $entityEntity) {
                        $entityAttributeCollection = $entityEntity->getAttributes();
                        $filedCollection = new Collection;
                        /** @var EntityAttributeEntity $entityAttributeEntity */
                        foreach ($entityAttributeCollection as $entityAttributeEntity) {
                            $attributeEntity = $entityAttributeEntity->getAttribute();
                            if ($entityAttributeEntity->getDefault() !== null) {
                                $attributeEntity->setDefault($entityAttributeEntity->getDefault());
                            }
                            if ($entityAttributeEntity->getIsRequired() !== null) {
                                $attributeEntity->setIsRequired($entityAttributeEntity->getIsRequired());
                            }
                            $filedCollection->add($attributeEntity);
                        }
                        $entityEntity->setAttributes($filedCollection);
                    }
                    return $collection;
                }
            ],
        ];
    }
}
