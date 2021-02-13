<?php

namespace ZnBundle\Eav\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'eav';
    }


}

