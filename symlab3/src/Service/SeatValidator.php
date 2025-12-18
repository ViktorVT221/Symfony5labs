<?php

namespace App\Service;

class SeatValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (!isset($data['rowNumber'])) {
            $errors[] = 'rowNumber is required';
        }

        if (!isset($data['seatNumber'])) {
            $errors[] = 'seatNumber is required';
        }

        return $errors;
    }
}
