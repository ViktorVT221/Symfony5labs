<?php

namespace App\Controller;

use App\Repository\CinemaRepository;
use App\Repository\HallRepository;
use App\Service\HallService;
use App\Service\HallValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/halls')]
class HallController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(HallRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        HallService $service,
        HallValidator $validator
    ): Response {
        $data = json_decode($request->getContent(), true);

        $errors = $validator->validate($data);
        if ($errors) {
            return $this->json($errors, 400);
        }

        return $this->json($service->create($data), 201);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        HallRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $hall = $repo->find($id);
        if (!$hall) {
            return $this->json(['error' => 'Not found'], 404);
        }

        $em->remove($hall);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
