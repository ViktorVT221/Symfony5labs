<?php

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function create(array $data): Movie
    {
        $movie = new Movie();
        $movie->setTitle($data['title']);
        $movie->setDescription($data['description'] ?? null);

        $this->em->persist($movie);
        $this->em->flush();

        return $movie;
    }
}
