<?php

/**
 * @var $formView FormView|AbstractType[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormRender;

/** @var CsrfTokenManagerInterface $tokenManager */
$tokenManager = ContainerHelper::getContainer()->get(CsrfTokenManagerInterface::class);
$formRender = new FormRender($formView, $tokenManager);
//$formRender->addFormOption('autocomplete', 'off');

?>

<!--
<h2><?/*= \ZnCore\Base\Libs\I18Next\Facades\I18Next::t('app_user', 'restore-password.action.create_password') */?></h2>
-->

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<div class="form-group required has-error">
    <?= $formRender->label('categoryId') ?>
    <?= $formRender->input('categoryId', 'text') ?>
    <?= $formRender->hint('categoryId') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('name') ?>
    <?= $formRender->input('name', 'text') ?>
    <?= $formRender->hint('name') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('title') ?>
    <?= $formRender->input('title', 'text') ?>
    <?= $formRender->hint('title') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('handler') ?>
    <?= $formRender->input('handler', 'text') ?>
    <?= $formRender->hint('handler') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('status') ?>
    <?= $formRender->input('status', 'text') ?>
    <?= $formRender->hint('status') ?>
</div>
<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
