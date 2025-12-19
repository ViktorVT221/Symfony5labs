<?php

namespace App\Service;

use App\Entity\Hall;
use App\Repository\CinemaRepository;
use Doctrine\ORM\EntityManagerInterface;

class HallService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CinemaRepository $cinemaRepo
    ) {}

    public function create(array $data): Hall
    {
        $cinema = $this->cinemaRepo->find($data['cinema_id']);

        $hall = new Hall();
        $hall->setName($data['name']);
        $hall->setCinema($cinema);

        $this->em->persist($hall);
        $this->em->flush();

        return $hall;
    }
}
