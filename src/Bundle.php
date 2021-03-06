<?php

namespace ZnBundle\Eav;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    /*public function yiiAdmin(): array
    {
        return [
            'modules' => [
                '' => __NAMESPACE__ . '\Yii2\Admin\Module',
            ],
        ];
    }*/

    public function symfonyAdmin(): array
    {
        return [
            __DIR__ . '/Symfony4/Admin/config/routing.php',
        ];
    }

    /*public function symfonyWeb(): array
    {
        return [
            __DIR__ . '/Symfony4/Web/config/routing.php',
        ];
    }*/

    public function i18next(): array
    {
        return [

        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/eav/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
