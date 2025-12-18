<?php

namespace App\Controller;

use App\Repository\CinemaRepository;
use App\Service\CinemaService;
use App\Service\CinemaValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cinemas')]
class CinemaController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(CinemaRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        CinemaService $service,
        CinemaValidator $validator
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
        CinemaRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $cinema = $repo->find($id);
        if (!$cinema) {
            return $this->json(['error' => 'Not found'], 404);
        }

        $em->remove($cinema);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
