<?php

namespace App\Service;

class CinemaValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        return $errors;
    }
}

