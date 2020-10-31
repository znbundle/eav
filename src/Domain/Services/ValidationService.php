<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Services\ValidationServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\ValidationRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class ValidationService extends BaseCrudService implements ValidationServiceInterface
{

    public function __construct(ValidationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

