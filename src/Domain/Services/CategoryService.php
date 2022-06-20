<?php

namespace ZnBundle\Eav\Domain\Services;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnBundle\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Query\Entities\Query;

/**
 * Class CategoryService
 * @package ZnBundle\Eav\Domain\Services
 * @method CategoryRepositoryInterface getRepository()
 */
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

    public function oneByName(string $name): CategoryEntity
    {
        return $this->getRepository()->oneByName($name);
    }
}
