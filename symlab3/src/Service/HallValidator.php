<?php

namespace App\Service;

class HallValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['cinema_id'])) {
            $errors['cinema_id'] = 'Cinema ID is required';
        }

        return $errors;
    }
}
