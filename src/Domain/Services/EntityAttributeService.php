<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Services\EntityAttributeServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class EntityAttributeService extends BaseCrudService implements EntityAttributeServiceInterface
{

    public function __construct(EntityAttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

