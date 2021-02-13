<?php

namespace ZnBundle\Eav\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class EntityEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;

    private $bookId = null;

    private $name = null;

    private $title = null;

    private $handler = null;

    private $status = null;

    private $attributes = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('bookId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('handler', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
    }

    public function getAttributeNames()
    {
        $attributes = $this->getAttributes();
        if ($attributes) {
            return EntityHelper::getColumn($attributes, 'name');
        }
        return null;
    }

    public function getRules()
    {
        $attributesCollection = $this->getAttributes();
        if (empty($attributesCollection)) {
            return null;
        }
        $rules = [];
        /** @var AttributeEntity $attributeEntity */
        foreach ($attributesCollection as $attributeEntity) {
            $attributeName = $attributeEntity->getName();
            foreach ($attributeEntity->getRules() as $ruleEntity) {
                $ruleName = $ruleEntity->getName();
                $isClassName = strpos($ruleName, '\\') !== false;
                $ruleClassName = $isClassName ? $ruleName : 'Symfony\Component\Validator\Constraints\\' . ucfirst($ruleName);
                if ($ruleClassName) {
                    $rules[$attributeName][] = new $ruleClassName;
                }
            }
            $enumCollection = $attributeEntity->getEnums();
            if ($enumCollection && $enumCollection->count() > 0) {
                $rules[$attributeName][] = new Assert\Choice([
                    'choices' => EntityHelper::getColumn($enumCollection, 'name'),
                ]);
            }
            if ($attributeEntity->getIsRequired()) {
                $rules[$attributeName][] = new Assert\NotBlank;
            }
        }
        return $rules;
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setBookId($value): void
    {
        $this->bookId = $value;
    }

    public function getBookId()
    {
        return $this->bookId;
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

    public function setHandler($value): void
    {
        $this->handler = $value;
    }

    public function getHandler()
    {
        return $this->handler;
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
     * @return Collection|null|AttributeEntity[]
     */
    public function getAttributes(): ?Collection
    {
        return $this->attributes;
    }

    public function setAttributes(Collection $attributes): void
    {
        $this->attributes = $attributes;
    }
}
