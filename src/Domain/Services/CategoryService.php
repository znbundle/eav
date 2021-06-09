<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class CategoryService extends BaseCrudService implements CategoryServiceInterface
{

    public function __construct(
        CategoryRepositoryInterface $repository,
        EntityManagerInterface $entityManager
    )
    {
        $this->setRepository($repository);
        $this->setEntityManager($entityManager);
    }
}
