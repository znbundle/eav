<?php

/**
 * @var View $view
 * @var $formRender FormRender
 */

use ZnBundle\Eav\Symfony4\Widgets\DynamicInput\DynamicInputWidget;
use ZnLib\Components\I18Next\Facades\I18Next;
use ZnLib\Web\Components\Form\Libs\FormRender;
use ZnLib\Web\Components\View\Libs\View;

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<?= DynamicInputWidget::widget([
    'formRender' => $formRender,
]) ?>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
