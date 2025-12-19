<?php

namespace App\Service;

class TicketValidator
{
    public function validate(?array $data): array
    {
        $errors = [];

        if (!$data) {
            return ['Invalid JSON'];
        }

        if (!isset($data['price']) || $data['price'] <= 0) {
            $errors[] = 'Price must be greater than 0';
        }

        if (empty($data['status'])) {
            $errors[] = 'Status is required';
        }

        if (empty($data['session_id'])) {
            $errors[] = 'Session is required';
        }

        if (empty($data['seat_id'])) {
            $errors[] = 'Seat is required';
        }

        if (empty($data['user_id'])) {
            $errors[] = 'User is required';
        }

        return $errors;
    }
}
