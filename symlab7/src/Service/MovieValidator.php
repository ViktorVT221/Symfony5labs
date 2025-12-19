<?php

namespace App\Service;

class MovieValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        }

        return $errors;
    }
}
