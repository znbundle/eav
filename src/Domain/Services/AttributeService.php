<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnCore\Service\Base\BaseCrudService;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;

class AttributeService extends BaseCrudService implements AttributeServiceInterface
{

    public function __construct(
        AttributeRepositoryInterface $repository,
        EntityManagerInterface $entityManager
    )
    {
        $this->setRepository($repository);
        $this->setEntityManager($entityManager);
    }
}
