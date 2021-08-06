<?php

namespace ZnBundle\Eav\Domain\Forms;

use Illuminate\Support\Collection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Entities\EnumEntity;
use ZnBundle\Eav\Domain\Libs\Rules;
use ZnBundle\Eav\Domain\Traits\DynamicAttribute;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Contract\Arr\Interfaces\ToArrayInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class DynamicForm implements BuildFormInterface, ToArrayInterface, ValidateEntityInterface
{

    use DynamicAttribute;

    protected $_entityEntity;
    protected $_validationRules = [];

    /*public function getAttributes(): array
    {
        return $this->attributes();
    }*/

    public function __construct(EntityEntity $entityEntity)
    {
        if ($entityEntity) {
            $this->_entityEntity = $entityEntity;
            $this->_attributes = $entityEntity->getAttributeNames();
            //$this->_validationRules = $entityEntity->getRules();
            $rulesLib = new Rules();
            $this->_validationRules = $rulesLib->convert($entityEntity->getAttributes());
        }
        if (empty($this->_attributes)) {
            throw new InvalidArgumentException('No attributes for dynamic entity!');
        }
        //dd($this->attributes());
        foreach ($this->attributes() as $attributeName) {
            $this->{$attributeName} = null;
        }
        //dd($this);
    }

    public function validationRules(): array
    {
        return $this->_validationRules;
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        /** @var AttributeEntity[] | Collection $attributesCollection */
        $attributesCollection = $this->_entityEntity->getAttributes();
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

    private function enumsToChoices(?Collection $enumCollection): array
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