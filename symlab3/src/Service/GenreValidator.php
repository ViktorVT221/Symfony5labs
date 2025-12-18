<?php

namespace App\Service;

class GenreValidator
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
