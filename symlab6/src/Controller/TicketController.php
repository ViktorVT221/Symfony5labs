<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use App\Service\TicketService;
use App\Service\TicketValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tickets')]
class TicketController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, TicketRepository $repo): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = isset($requestData['itemsPerPage'])
            ? (int)$requestData['itemsPerPage']
            : 10;

        $page = isset($requestData['page'])
            ? (int)$requestData['page']
            : 1;

        $ticketsData = $repo->getAllTicketsByFilter(
            $requestData,
            $itemsPerPage,
            $page
        );

        return $this->json($ticketsData);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id, TicketRepository $repo): Response
    {
        $ticket = $repo->find($id);

        if (!$ticket) {
            return $this->json(['error' => 'Ticket not found'], 404);
        }

        return $this->json($ticket);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        TicketService $service,
        TicketValidator $validator
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
        TicketRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $ticket = $repo->find($id);

        if (!$ticket) {
            return $this->json(['error' => 'Ticket not found'], 404);
        }

        $em->remove($ticket);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
