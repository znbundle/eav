<?php

namespace ZnBundle\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class EntityAttributeEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;

    private $entityId = null;

    private $attributeId = null;

    private $default = null;

    private $isRequired = null;

    private $name = null;

    private $title = null;

    private $description = null;

    private $sort = null;

    private $status = null;

    private $isList = false;

    private $attribute;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('entityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('attributeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('sort', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('isList', new Assert\NotBlank);
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEntityId($value): void
    {
        $this->entityId = $value;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setattributeId($value): void
    {
        $this->attributeId = $value;
    }

    public function getattributeId()
    {
        return $this->attributeId;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default): void
    {
        $this->default = $default;
    }

    public function getIsRequired()
    {
        return $this->isRequired;
    }

    public function setIsRequired($isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function setName($value): void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
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

    public function setSort($value): void
    {
        $this->sort = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isList(): bool
    {
        return $this->isList;
    }

    public function setIsList(bool $isList): void
    {
        $this->isList = $isList;
    }

    public function getAttribute(): ?AttributeEntity
    {
        return $this->attribute;
    }

    public function setAttribute(AttributeEntity $attribute): void
    {
        $this->attribute = $attribute;
    }

}
