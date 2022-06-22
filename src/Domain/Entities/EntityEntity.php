<?php

namespace ZnBundle\Eav\Domain\Entities;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnBundle\Eav\Domain\Libs\Rules;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class EntityEntity implements ValidationByMetadataInterface, EntityIdInterface, BuildFormInterface
{

    private $id = null;

    private $categoryId = null;

    private $name = null;

    private $title = null;

    private $handler = null;

    private $status = StatusEnum::ENABLED;

    private $attributes = null;

    private $attributesTie = null;

    private $category = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('categoryId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('handler', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status', new Assert\NotBlank);
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        $formBuilder
            ->add('categoryId', TextType::class, [
                'label' => 'categoryId'
            ])
            ->add('name', TextType::class, [
                'label' => 'name'
            ])
            ->add('title', TextType::class, [
                'label' => 'title'
            ])
            ->add('handler', TextType::class, [
                'label' => 'handler'
            ])
            /*->add('status', TextType::class, [
                'label' => 'status'
            ])*/
            ;
    }

    public function getAttributeNames()
    {
        $attributes = $this->getAttributes();
        if ($attributes) {
            return CollectionHelper::getColumn($attributes, 'name');
        }
        return null;
    }

    /**
     * @return array|null|Constraint[]
     */
    public function getRules()
    {
        $attributesCollection = $this->getAttributes();
        if (empty($attributesCollection)) {
            return null;
        }
        $rulesLib = new Rules();
        return $rulesLib->convert($attributesCollection);
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCategoryId($value): void
    {
        $this->categoryId = $value;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
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

    public function setAttributes(?Collection $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAttributesTie(): ?Collection
    {
        return $this->attributesTie;
    }

    public function setAttributesTie(Collection $attributesTie): void
    {
        $this->attributesTie = $attributesTie;
    }

    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(CategoryEntity $category): void
    {
        $this->category = $category;
    }
}
