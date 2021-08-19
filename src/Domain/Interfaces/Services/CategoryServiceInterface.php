<?php

namespace ZnBundle\Eav\Domain\Interfaces\Services;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface CategoryServiceInterface extends CrudServiceInterface
{

    public function oneByName(string $name): CategoryEntity;
}
