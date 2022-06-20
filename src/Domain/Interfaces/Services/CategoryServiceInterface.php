<?php

namespace ZnBundle\Eav\Domain\Interfaces\Services;

use ZnBundle\Eav\Domain\Entities\CategoryEntity;
use ZnCore\Base\Libs\Service\Interfaces\CrudServiceInterface;

interface CategoryServiceInterface extends CrudServiceInterface
{

    public function oneByName(string $name): CategoryEntity;
}
