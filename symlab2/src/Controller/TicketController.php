<?php

namespace App\Controller;

use App\Entity\Ticket;
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
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->json($ticketRepository->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id, TicketRepository $ticketRepository): Response
    {
        $ticket = $ticketRepository->find($id);

        if (!$ticket) {
            return $this->json(['error' => 'Ticket not found'], 404);
        }

        return $this->json($ticket);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        TicketService $ticketService,
        TicketValidator $validator
    ): Response {
        $data = json_decode($request->getContent(), true);

        $errors = $validator->validate($data);
        if ($errors) {
            return $this->json(['errors' => $errors], 400);
        }

        $ticket = $ticketService->create($data);

        return $this->json($ticket, 201);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        TicketRepository $ticketRepository,
        EntityManagerInterface $em
    ): Response {
        $ticket = $ticketRepository->find($id);

        if (!$ticket) {
            return $this->json(['error' => 'Ticket not found'], 404);
        }

        $em->remove($ticket);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
