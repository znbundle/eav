<?php

namespace ZnBundle\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnLib\Components\Status\Enums\StatusEnum;
use ZnDomain\Сomponents\Constraints\Enum;
use ZnDomain\Validator\Interfaces\ValidationByMetadataInterface;
use ZnDomain\Entity\Interfaces\UniqueInterface;
use ZnDomain\Entity\Interfaces\EntityIdInterface;

class ValueEntity implements ValidationByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $entityId = null;

    private $recordId = null;

    private $attributeId = null;

    private $value = null;

    private $statusId = StatusEnum::ENABLED;

    private $createdAt = null;

    private $updatedAt = null;

    private $attribute;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('entityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('recordId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('attributeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('value', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
        ]));
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank);
    }

    public function unique() : array
    {
        return [
            ['entity_id', 'attribute_id']
        ];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEntityId($value) : void
    {
        $this->entityId = $value;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setRecordId($value) : void
    {
        $this->recordId = $value;
    }

    public function getRecordId()
    {
        return $this->recordId;
    }

    public function getAttributeId()
    {
        return $this->attributeId;
    }

    public function setAttributeId($attributeId): void
    {
        $this->attributeId = $attributeId;
    }

    public function setValue($value) : void
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
