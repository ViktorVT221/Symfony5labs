<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Service\MovieService;
use App\Service\MovieValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movies')]
class MovieController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, MovieRepository $repo): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = isset($requestData['itemsPerPage'])
            ? (int)$requestData['itemsPerPage']
            : 10;

        $page = isset($requestData['page'])
            ? (int)$requestData['page']
            : 1;

        $moviesData = $repo->getAllMoviesByFilter(
            $requestData,
            $itemsPerPage,
            $page
        );

        return $this->json($moviesData);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id, MovieRepository $repo): Response
    {
        $movie = $repo->find($id);

        if (!$movie) {
            return $this->json(['error' => 'Not found'], 404);
        }

        return $this->json($movie);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        MovieService $service,
        MovieValidator $validator
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
        MovieRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $movie = $repo->find($id);

        if (!$movie) {
            return $this->json(['error' => 'Not found'], 404);
        }

        $em->remove($movie);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
