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
