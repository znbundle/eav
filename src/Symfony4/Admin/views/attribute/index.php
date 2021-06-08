<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $entityCollection Collection | EntityEntity[]
 * @var DataProvider $dataProvider
 */

use Illuminate\Support\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormRender;
use ZnLib\Web\Widgets\Tab\TabWidget;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\ImageFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

//$this->title = I18Next::t('info', 'certificate.list');

//$statusWidget = new FilterWidget(StatusEnum::class, $filterModel);

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.title'),
        'attributeName' => 'title',
        'sort' => true,
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => '/info/certificate/view',
        ],
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => '/info/certificate',
        ],
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left">
            <a class="btn btn-primary" href="<?= Url::to(['/info/certificate/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
