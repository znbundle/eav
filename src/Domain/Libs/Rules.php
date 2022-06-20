<?php

namespace ZnBundle\Eav\Domain\Libs;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnBundle\Eav\Domain\Entities\EntityAttributeEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnCore\Domain\Constraints\Boolean;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;

class Rules
{

    private $rules = [];

    public function convert(Collection $attributesCollection): array
    {
        $this->rules = [];
        /** @var AttributeEntity $attributeEntity */
        foreach ($attributesCollection as $attributeEntity) {
            $attributeName = $attributeEntity->getName();
            $this->handleRules($attributeEntity, $attributeName);
            $this->castChoices($attributeEntity, $attributeName);
            $this->castBoolean($attributeEntity, $attributeName);
            $this->castRequired($attributeEntity, $attributeName);
        }
        return $this->rules;
    }

    private function addRule(string $attributeName, Constraint $constraint)
    {
        $this->rules[$attributeName][] = $constraint;
    }

    private function handleRules(AttributeEntity $attributeEntity, string $attributeName)
    {
        foreach ($attributeEntity->getRules() as $ruleEntity) {
            $ruleName = $ruleEntity->getName();
            $isClassName = strpos($ruleName, '\\') !== false;
            $ruleClassName = $isClassName ? $ruleName : 'Symfony\Component\Validator\Constraints\\' . ucfirst($ruleName);
            if ($ruleClassName) {
                $params = $ruleEntity->getParams();
                if ($params) {
                    $params = json_decode($params);
                    $constraintInstance = new $ruleClassName($params);
                } else {
                    $constraintInstance = new $ruleClassName();
                }
                $this->addRule($attributeName, $constraintInstance);
            }
        }
    }

    private function castChoices(AttributeEntity $attributeEntity, string $attributeName)
    {
        $enumCollection = $attributeEntity->getEnums();
        if ($enumCollection && $enumCollection->count() > 0) {
            $choiceConstraint = new Assert\Choice([
                'choices' => EntityHelper::getColumn($enumCollection, 'name'),
            ]);
            $this->addRule($attributeName, $choiceConstraint);
        }
    }

    private function castBoolean(AttributeEntity $attributeEntity, string $attributeName)
    {
        $isBoolean = $attributeEntity->getType() == 'boolean' || $attributeEntity->getType() == 'bool';
        if ($isBoolean) {
            $choiceConstraint = new Boolean();
            $this->addRule($attributeName, $choiceConstraint);
        }
    }

    private function castRequired(AttributeEntity $attributeEntity, string $attributeName)
    {
        if ($attributeEntity->getIsRequired()) {
            $this->addRule($attributeName, new Assert\NotBlank);
        } elseif (!$attributeEntity->getIsRequired()) {
            $this->addRule($attributeName, new Assert\Length(['min' => 0]));
        }
    }
}
