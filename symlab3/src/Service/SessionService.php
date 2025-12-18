<?php

namespace App\Service;

use App\Entity\Session;
use App\Repository\MovieRepository;
use App\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;

class SessionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private MovieRepository $movieRepo,
        private HallRepository $hallRepo
    ) {}

    public function create(array $data): Session
    {
        $session = new Session();
        $session->setStartTime(new \DateTime($data['startTime']));
        $session->setMovie($this->movieRepo->find($data['movieId']));
        $session->setHall($this->hallRepo->find($data['hallId']));

        $this->em->persist($session);
        $this->em->flush();

        return $session;
    }
}
