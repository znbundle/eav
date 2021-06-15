<?php

/**
 * @var $baseUri string
 * @var $this View
 * @var $entity AttributeEntity
 */

use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Symfony4\MicroApp\Helpers\ActionHelper;
use ZnLib\Web\View\View;
use ZnLib\Web\Widgets\Detail\DetailWidget;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.title'),
        'attributeName' => 'title',
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => $baseUri . '/view',
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

        <div class="mb-3">
            <?= ActionHelper::generateUpdateAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
            <?= ActionHelper::generateDeleteAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
        </div>

        <div class="mb-3">
            <h3>Validation rules</h3>
            <?= $this->renderFile(__DIR__ . '/validation/index.php', [
                'collection' => $entity->getRules(),
                'baseUri' => $baseUri . '/validation',
            ]); ?>
        </div>

        <div class="mb-3">
            <h3>Enums</h3>
            <?= $this->renderFile(__DIR__ . '/enums/index.php', [
                'collection' => $entity->getEnums(),
                'baseUri' => $baseUri . '/enums',
            ]); ?>
        </div>

    </div>
</div>
