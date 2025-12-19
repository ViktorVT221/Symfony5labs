<?php

namespace App\Service;

use App\Entity\Cinema;
use Doctrine\ORM\EntityManagerInterface;

class CinemaService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function create(array $data): Cinema
    {
        $cinema = new Cinema();
        $cinema->setName($data['name']);

        $this->em->persist($cinema);
        $this->em->flush();

        return $cinema;
    }
}
