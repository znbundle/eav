<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;

class AttributeService extends BaseCrudService implements AttributeServiceInterface
{

    public function __construct(AttributeRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }


}

