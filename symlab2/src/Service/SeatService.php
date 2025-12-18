<?php

namespace App\Service;

use App\Entity\Seat;
use Doctrine\ORM\EntityManagerInterface;

class SeatService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function create(array $data): Seat
    {
        $seat = new Seat();
        $seat->setRowNumber($data['rowNumber']);
        $seat->setSeatNumber($data['seatNumber']);

        $this->em->persist($seat);
        $this->em->flush();

        return $seat;
    }
}
