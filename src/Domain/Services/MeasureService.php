<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Services\MeasureServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class MeasureService extends BaseCrudService implements MeasureServiceInterface
{

    public function __construct(MeasureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

}
