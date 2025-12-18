<?php

namespace App\Controller;

use App\Repository\SeatRepository;
use App\Service\SeatService;
use App\Service\SeatValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/seats')]
class SeatController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, SeatRepository $repo): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = isset($requestData['itemsPerPage'])
            ? (int)$requestData['itemsPerPage']
            : 10;

        $page = isset($requestData['page'])
            ? (int)$requestData['page']
            : 1;

        $seatsData = $repo->getAllSeatsByFilter(
            $requestData,
            $itemsPerPage,
            $page
        );

        return $this->json($seatsData);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        SeatService $service,
        SeatValidator $validator
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
        SeatRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $seat = $repo->find($id);

        if (!$seat) {
            return $this->json(['error' => 'Seat not found'], 404);
        }

        $em->remove($seat);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
