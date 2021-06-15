<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $collection ValidationEntity[] | Collection
 * @var $baseUri string
 */

use Illuminate\Support\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnBundle\Eav\Domain\Entities\ValidationEntity;
use ZnBundle\Eav\Domain\Enums\AttributeTypeEnum;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\BooleanFormatter;
use ZnLib\Web\Widgets\Format\Formatters\EnumFormatter;
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
    [
        'label' => I18Next::t('core', 'main.attribute.name'),
        'attributeName' => 'name',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.type'),
        'attributeName' => 'type',
        'formatter' => [
            'class' => EnumFormatter::class,
            'enumClass' => AttributeTypeEnum::class,
        ],
    ],
    [
        'label' => 'is_required',
        'attributeName' => 'is_required',
        'formatter' => [
            'class' => BooleanFormatter::class,
        ],
    ],
    [
        'label' => 'default',
        'attributeName' => 'default',
    ],
    /*[
        'label' => 'description',
        'attributeName' => 'description',
    ],
    [
        'label' => 'unit_id',
        'attributeName' => 'unit_id',
    ],*/
    [
        'label' => 'status',
        'attributeName' => 'status',
        'formatter' => [
            'class' => EnumFormatter::class,
            'enumClass' => StatusEnum::class,
        ],
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => $baseUri,
        ],
    ],
];

?>

<?= CollectionWidget::widget([
    'collection' => $collection,
    'attributes' => $attributes,
]) ?>
<div class="float-left111">
    <a class="btn btn-primary" href="<?= Url::to([$baseUri . '/create']) ?>" role="button">
        <i class="fa fa-plus"></i>
        <?= I18Next::t('core', 'action.create') ?>
    </a>
</div>
