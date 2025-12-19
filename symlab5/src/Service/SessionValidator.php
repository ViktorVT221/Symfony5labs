<?php

namespace App\Service;

class SessionValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        foreach (['startTime', 'movieId', 'hallId'] as $field) {
            if (!isset($data[$field])) {
                $errors[] = "$field is required";
            }
        }

        return $errors;
    }
}
