<?php

namespace ZnBundle\Eav\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class AttributeEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;

    private $name = null;

    private $type = null;

    private $default = null;

    private $isRequired = null;

    private $title = null;

    private $description = null;

    private $unitId = null;

    private $status = null;

    private $rules;

    private $enums;

    private $unit;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('type', new Assert\NotBlank);
        $metadata->addPropertyConstraint('default', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('unitId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
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

    public function setUnit(MeasureEntity $unit): void
    {
        $this->unit = $unit;
    }

}
