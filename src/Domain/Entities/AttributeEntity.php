<?php

namespace ZnBundle\Eav\Domain\Entities;

use App\Rpc\Domain\Enums\RpcCryptoProviderStrategyEnum;
use Illuminate\Support\Collection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnBundle\Eav\Domain\Enums\AttributeTypeEnum;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Helpers\EnumHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class AttributeEntity implements ValidateEntityByMetadataInterface, EntityIdInterface, BuildFormInterface
{

    private $id = null;

    private $name = null;

    private $type = null;

    private $default = null;

    private $isRequired = null;

    private $title = null;

    private $description = null;

    private $unitId = null;

    private $status = StatusEnum::ENABLED;

    private $rules;

    private $enums;

    private $unit;

    private $tie;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        //$metadata->addPropertyConstraint('id', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('type', new Assert\NotBlank);
        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => EnumHelper::getValues(AttributeTypeEnum::class),
        ]));
        //$metadata->addPropertyConstraint('default', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        //$metadata->addPropertyConstraint('description', new Assert\NotBlank);
        //$metadata->addPropertyConstraint('unitId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('unitId', new Assert\Positive());
//        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        $formBuilder
            ->add('name', TextType::class, [
                'label' => 'name'
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'type',
                'choices' => array_flip(EnumHelper::getOptions(AttributeTypeEnum::class)),
            ])
            ->add('default', TextType::class, [
                'label' => 'default'
            ])
            ->add('title', TextType::class, [
                'label' => 'title'
            ])
            ->add('description', TextType::class, [
                'label' => 'description'
            ])
            ->add('unitId', TextType::class, [
                'label' => 'unitId'
            ])/*->add('status', TextType::class, [
                'label' => 'status'
            ])*/
        ;
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($value): void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($value): void
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDefault($value): void
    {
        $this->default = $value;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getIsRequired()
    {
        return $this->isRequired;
    }

    public function setIsRequired($isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function setTitle($value): void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($value): void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setUnitId($value): void
    {
        $this->unitId = $value;
    }

    public function getUnitId()
    {
        return $this->unitId;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return ValidationEntity[]|null|Collection
     */
    public function getRules(): ?Collection
    {
        return $this->rules;
    }

    public function setRules(Collection $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return EnumEntity[]|null|Collection
     */
    public function getEnums(): ?Collection
    {
        return $this->enums;
    }

    public function setEnums(Collection $enums): void
    {
        $this->enums = $enums;
    }

    public function getUnit(): ?MeasureEntity
    {
        return $this->unit;
    }

    public function setUnit(?MeasureEntity $unit): void
    {
        $this->unit = $unit;
    }

    public function getTie(): ?EntityAttributeEntity
    {
        return $this->tie;
    }

    public function setTie(EntityAttributeEntity $tie): void
    {
        $this->tie = $tie;
    }

}
