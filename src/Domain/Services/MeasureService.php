<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\MeasureServiceInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;

class MeasureService extends BaseCrudService implements MeasureServiceInterface
{

    public function __construct(MeasureRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

}
