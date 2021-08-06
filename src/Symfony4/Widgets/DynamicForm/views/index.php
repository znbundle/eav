<?php

/**
 * @var View $view
 * @var $formRender FormRender
 */

use ZnBundle\Eav\Symfony4\Widgets\DynamicInput\DynamicInputWidget;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormRender;
use ZnLib\Web\View\View;

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
