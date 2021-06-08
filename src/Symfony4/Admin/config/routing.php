<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnBundle\Eav\Symfony4\Admin\Controllers\AttributeController;
use ZnBundle\Eav\Symfony4\Admin\Controllers\CategoryController;
use ZnBundle\Eav\Symfony4\Admin\Controllers\EntityController;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('eav/category', '/eav/category')
        ->controller([CategoryController::class, 'index'])
        ->methods(['GET', 'POST']);


    $routes
        ->add('eav/entity', '/eav/entity')
        ->controller([EntityController::class, 'index'])
        ->methods(['GET', 'POST']);


    $routes
        ->add('eav/attribute', '/eav/attribute')
        ->controller([AttributeController::class, 'index'])
        ->methods(['GET', 'POST']);
};
