<?php

namespace ZnBundle\Eav\Domain\Forms;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Traits\DynamicAttribute;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Libs\ArrayTools\Helpers\Collection;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Contract\Arr\Interfaces\ToArrayInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class DynamicForm implements BuildFormInterface, ToArrayInterface
{

    use DynamicAttribute;

    protected $_entityEntity;

    public function __construct(EntityEntity $entityEntity)
    {
        if ($entityEntity) {
            $this->_entityEntity = $entityEntity;
            $this->_attributes = $entityEntity->getAttributeNames();
            //$this->_validationRules = $entityEntity->getRules();
        }
        if (empty($this->_attributes)) {
            throw new InvalidArgumentException('No attributes for dynamic entity!');
        }
    }

    public function toArray(): array
    {
        $values = [];
        /** @var AttributeEntity[] | Collection $attributesCollection */
        $attributesCollection = $this->_entityEntity->getAttributes();
        foreach ($attributesCollection as $attributeEntity) {
            $name = $attributeEntity->getName();
            $values[$name] = $this->__get($name);
        }
        return $values;
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        /** @var AttributeEntity[] | Collection $attributesCollection */
        $attributesCollection = $this->_entityEntity->getAttributes();
        foreach ($attributesCollection as $attributeEntity) {
            $formBuilder->add($attributeEntity->getName(), TextType::class, [
                'label' => $attributeEntity->getTitle()
            ]);
        }
        $formBuilder->add('save', SubmitType::class, [
            'label' => I18Next::t('core', 'action.save')
        ]);
    }
}
