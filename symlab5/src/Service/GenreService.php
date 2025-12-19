<?php

namespace App\Service;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;

class GenreService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function create(array $data): Genre
    {
        $genre = new Genre();
        $genre->setName($data['name']);

        $this->em->persist($genre);
        $this->em->flush();

        return $genre;
    }
}
