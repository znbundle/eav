<?php

namespace ZnBundle\Eav\Yii2\Api\controllers;

use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use Yii;
use yii\base\Module;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class EntityController extends BaseCrudController
{

    public function __construct(string $id, Module $module, array $config = [], EntityServiceInterface $bookService)
    {
        parent::__construct($id, $module, $config);
        $this->service = $bookService;
    }

    public function actionValidate(int $entityId)
    {
        $dynamicEntity = $this->service->validate($entityId, Yii::$app->request->post());
        return EntityHelper::toArray($dynamicEntity);
        //\Yii::$app->response->setStatusCode(HttpStatusCodeEnum::NO_CONTENT);
    }
}
