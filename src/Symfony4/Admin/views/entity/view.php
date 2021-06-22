<?php

/**
 * @var $baseUri string
 * @var $this View
 * @var $entity EntityEntity
 */

use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnLib\Web\Symfony4\MicroApp\Helpers\ActionHelper;
use ZnLib\Web\View\View;
use ZnLib\Web\Widgets\Detail\DetailWidget;
use ZnLib\Web\Widgets\Format\Formatters\EnumFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

//dd($entity);

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.title'),
        'attributeName' => 'title',
        /*'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => $baseUri . '/view',
        ],*/
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.name'),
        'attributeName' => 'name',
    ],
    [
        'label' => 'category',
        'attributeName' => 'category.title',
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => '/eav/category/view',
        ],
    ],
    [
        'label' => 'handler',
        'attributeName' => 'handler',
    ],
    [
        'label' => 'status',
        'attributeName' => 'status',
        'formatter' => [
            'class' => EnumFormatter::class,
            'enumClass' => StatusEnum::class,
        ],
    ],
];

?>

<div class="row">
    <div class="col-lg-12">

        <?= DetailWidget::widget([
            'entity' => $entity,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left111 mb-3">
            <?= ActionHelper::generateUpdateAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
            <?= ActionHelper::generateDeleteAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
        </div>

        <div class="mb-3">
            <h3>Attributes</h3>
            <?= $this->renderFile(__DIR__ . '/attribute/index.php', [
                'collection' => $entity->getAttributesTie(),
                'baseUri' => '/eav/attribute',
            ]); ?>
        </div>

    </div>
</div>
