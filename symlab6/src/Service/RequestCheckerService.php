<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestCheckerService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Перевірка обовʼязкових полів
     */
    public function check(array $content, array $requiredFields): void
    {
        if (empty($content)) {
            throw new BadRequestException('Empty request body');
        }

        $missing = [];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $content)) {
                $missing[] = $field;
            }
        }

        if (!empty($missing)) {
            throw new BadRequestException(
                'Missing required fields: ' . implode(', ', $missing)
            );
        }
    }

    /**
     * Валідація через Constraints
     */
    public function validateRequestDataByConstraints(object|array $data, ?array $constraints = null): void
    {
        $errors = $this->validator->validate(
            $data,
            $constraints ? new Collection($constraints) : null
        );

        if (count($errors) === 0) {
            return;
        }

        $formattedErrors = [];

        foreach ($errors as $error) {
            $key = trim($error->getPropertyPath(), '[]');
            $formattedErrors[$key] = $error->getMessage();
        }

        throw new UnprocessableEntityHttpException(
            json_encode($formattedErrors)
        );
    }
}
