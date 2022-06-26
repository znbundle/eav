<?php

/**
 * @var $baseUri string
 * @var $this View
 * @var $entity EntityIdInterface
 */

use ZnLib\Components\I18Next\Facades\I18Next;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnLib\Web\Components\Controller\Helpers\ActionHelper;
use ZnLib\Web\Components\View\Libs\View;
use ZnLib\Web\Components\TwBootstrap\Widgets\Detail\DetailWidget;
use ZnLib\Web\Components\TwBootstrap\Widgets\Format\Formatters\LinkFormatter;

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
    [
        'label' => I18Next::t('core', 'main.attribute.name'),
        'attributeName' => 'name',
    ],
];

?>

<div class="row">
    <div class="col-lg-12">

        <?= DetailWidget::widget([
            'entity' => $entity,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left111">
            <?= ActionHelper::generateUpdateAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
            <?= ActionHelper::generateDeleteAction($entity, $baseUri, ActionHelper::TYPE_BUTTON) ?>
        </div>

    </div>
</div>
