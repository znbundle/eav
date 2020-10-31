<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Services\EnumServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class EnumService extends BaseCrudService implements EnumServiceInterface
{

    public function __construct(EnumRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

