<?php

namespace App\Service;

class UserValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors[] = 'email is required';
        }

        if (empty($data['password'])) {
            $errors[] = 'password is required';
        }

        return $errors;
    }
}
