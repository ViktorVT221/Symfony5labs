<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Service\GenreService;
use App\Service\GenreValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genres')]
class GenreController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, GenreRepository $repo): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = isset($requestData['itemsPerPage'])
            ? (int)$requestData['itemsPerPage']
            : 10;

        $page = isset($requestData['page'])
            ? (int)$requestData['page']
            : 1;

        $result = $repo->getAllGenresByFilter(
            $requestData,
            $itemsPerPage,
            $page
        );

        return $this->json($result);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        GenreService $service,
        GenreValidator $validator
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
        GenreRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $genre = $repo->find($id);

        if (!$genre) {
            return $this->json(['error' => 'Not found'], 404);
        }

        $em->remove($genre);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
