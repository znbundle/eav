<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class AttributeService extends BaseCrudService implements AttributeServiceInterface
{

    public function __construct(AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

