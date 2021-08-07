<?php

namespace ZnBundle\Eav\Domain\Forms;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EnumEntity;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\ArrayTools\Helpers\Collection;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Contract\Arr\Interfaces\ToArrayInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class DynamicForm2 extends DynamicEntity implements BuildFormInterface, ToArrayInterface
{

    public function getAttributes(): array
    {
        return $this->attributes();
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        /** @var AttributeEntity[] | Collection $attributesCollection */
        $attributesCollection = $this->entity()->getAttributes();
        foreach ($attributesCollection as $attributeEntity) {
            $typeInfo = $this->convertType($attributeEntity);
            $attributeOptions = [
                'label' => $attributeEntity->getTitle()
            ];
            $attributeOptions = ArrayHelper::merge($attributeOptions, $typeInfo['options'] ?? []);
            $formBuilder->add($attributeEntity->getName(), $typeInfo['class'], $attributeOptions);
        }
        $formBuilder->add('save', SubmitType::class, [
            'label' => I18Next::t('core', 'action.save')
        ]);
    }

    private function convertType(AttributeEntity $attributeEntity)
    {
        $type = $attributeEntity->getType();
        $default = [
            'class' => TextType::class,
            'options' => [],
        ];
        $assoc = [
            'string' => [
                'class' => TextType::class,
                'options' => [],
            ],
            'text' => [
                'class' => TextareaType::class,
                'options' => [],
            ],
            'integer' => [
                'class' => NumberType::class,
                'options' => [],
            ],
            'enum' => [
                'class' => ChoiceType::class,
                'options' => [
                    'choices' => $this->enumsToChoices($attributeEntity->getEnums()),
                ],
            ],
        ];
        return $assoc[$type] ?? $default;
    }

    private function enumsToChoices(?\Illuminate\Support\Collection $enumCollection): array
    {
        if(empty($enumCollection)) {
            return [];
        }
        $options = [];
        /** @var EnumEntity[] $enumCollection */
        foreach ($enumCollection as $enumEntity) {
            $options[$enumEntity->getTitle()] = $enumEntity->getName();
        }
        return $options;
    }
}
