<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\UserService;
use App\Service\UserValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(UserRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        UserService $service,
        UserValidator $validator
    ): Response {
        $data = json_decode($request->getContent(), true);

        if ($errors = $validator->validate($data)) {
            return $this->json($errors, 400);
        }

        return $this->json($service->create($data), 201);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        UserRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $user = $repo->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $em->remove($user);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
