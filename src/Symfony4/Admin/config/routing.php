<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnBundle\Eav\Symfony4\Admin\Controllers\AttributeController;
use ZnBundle\Eav\Symfony4\Admin\Controllers\CategoryController;
use ZnBundle\Eav\Symfony4\Admin\Controllers\EntityController;
use ZnLib\Web\Symfony4\MicroApp\Helpers\RouteHelper;

return function (RoutingConfigurator $routes) {
    RouteHelper::generateCrud($routes, EntityController::class, '/eav/entity');
    RouteHelper::generateCrud($routes, CategoryController::class, '/eav/category');
    RouteHelper::generateCrud($routes, AttributeController::class, '/eav/attribute');
};
