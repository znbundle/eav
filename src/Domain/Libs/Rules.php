<?php

namespace ZnBundle\Eav\Domain\Libs;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ZnBundle\Eav\Domain\Entities\AttributeEntity;
use ZnCore\Domain\Helpers\EntityHelper;

class Rules
{

    public function convert(Collection $attributesCollection): array
    {
        $rules = [];
        /** @var AttributeEntity $attributeEntity */
        foreach ($attributesCollection as $attributeEntity) {
            $attributeName = $attributeEntity->getName();
            foreach ($attributeEntity->getRules() as $ruleEntity) {
                $ruleName = $ruleEntity->getName();
                $isClassName = strpos($ruleName, '\\') !== false;
                $ruleClassName = $isClassName ? $ruleName : 'Symfony\Component\Validator\Constraints\\' . ucfirst($ruleName);
                if ($ruleClassName) {
                    $params = $ruleEntity->getParams();
                    if ($params) {
                        $params = json_decode($params);
                        $rules[$attributeName][] = new $ruleClassName($params);
                    } else {
                        $rules[$attributeName][] = new $ruleClassName();
                    }
                }
            }
            $enumCollection = $attributeEntity->getEnums();
            if ($enumCollection && $enumCollection->count() > 0) {
                $rules[$attributeName][] = new Assert\Choice([
                    'choices' => EntityHelper::getColumn($enumCollection, 'name'),
                ]);
            }
            $isBoolean = $attributeEntity->getType() == 'boolean' || $attributeEntity->getType() == 'bool';
            if ($isBoolean) {
                $rules[$attributeName][] = new Assert\Choice([
                    'choices' => [true, false],
                ]);
            } elseif ($attributeEntity->getIsRequired()) {
                $rules[$attributeName][] = new Assert\NotBlank;
            } elseif (!$attributeEntity->getIsRequired()) {
                $rules[$attributeName][] = new Assert\Length(['min' => 0]);
            }
            /*if ($attributeEntity->getIsRequired() && !$isBoolean) {
                $rules[$attributeName][] = new Assert\NotBlank;
            }*/
        }
        return $rules;
    }
}
