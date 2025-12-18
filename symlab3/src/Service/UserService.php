<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function create(array $data): User
    {
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
