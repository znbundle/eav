<?php

namespace ZnBundle\Eav\Domain\Libs;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use ZnCore\Base\Validation\Entities\ValidationErrorEntity;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Validation\Helpers\SymfonyValidationHelper;

class Validator
{

    public function validate(array $data, array $rules)
    {
        $violations = $this->validateData($data, $rules);
        $errorCollection = $this->createErrorCollectionFromViolationList($violations);
        if ($errorCollection->count()) {
            $exception = new UnprocessibleEntityException;
            $exception->setErrorCollection($errorCollection);
            throw $exception;
        }
    }

    public function validateData(array $data, array $rules): ConstraintViolationList
    {
        //$rules = $entity->validationRules();
        $validator = SymfonyValidationHelper::createValidator();
        $constraints = new Assert\Collection($rules);
        $violations = $validator->validate($data, $constraints);
        $newViolationArray = [];
        foreach ($violations as $violation) {
            /** @var $violation ConstraintViolation */
            $name = trim($violation->getPropertyPath(), '[]');
            $newViolationArray[] = new ConstraintViolation($violation->getMessage(), $violation->getMessageTemplate(), $violation->getParameters(), $violation->getRoot(), $name, $violation->getInvalidValue(), $violation->getPlural(), $violation->getCode(), $violation->getConstraint(), $violation->getCause());
        }
        return new ConstraintViolationList($newViolationArray);
    }

    public function createErrorCollectionFromViolationList(ConstraintViolationList $violations): Collection
    {
        $collection = new Collection;
        foreach ($violations as $violation) {
            //$name = trim($violation->getPropertyPath(), '[]');
            $name = $violation->getPropertyPath();
            $entity = new ValidationErrorEntity;
            $entity->setField($name);
            $entity->setMessage($violation->getMessage());
            $entity->setViolation($violation);
            $collection->add($entity);
        }
        return $collection;
    }
}
