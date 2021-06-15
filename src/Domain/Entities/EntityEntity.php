<?php

namespace ZnBundle\Eav\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class EntityEntity implements ValidateEntityByMetadataInterface, EntityIdInterface, BuildFormInterface
{

    private $id = null;

    private $categoryId = null;

    private $name = null;

    private $title = null;

    private $handler = null;

    private $status = StatusEnum::ENABLED;

    private $attributes = null;

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
            return EntityHelper::getColumn($attributes, 'name');
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
            $isBoolean = $attributeEntity->getType() == 'boolean' || $attributeEntity->getType() == 'bool';
            if($isBoolean) {
                $rules[$attributeName][] = new Assert\Choice([
                    'choices' => [true, false],
                ]);
            } elseif($attributeEntity->getIsRequired()) {
                $rules[$attributeName][] = new Assert\NotBlank;
            }
            /*if ($attributeEntity->getIsRequired() && !$isBoolean) {
                $rules[$attributeName][] = new Assert\NotBlank;
            }*/
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

    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(CategoryEntity $category): void
    {
        $this->category = $category;
    }
}
