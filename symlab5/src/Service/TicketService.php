<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Repository\SessionRepository;
use App\Repository\SeatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class TicketService
{
    public function __construct(
        private EntityManagerInterface $em,
        private SessionRepository $sessionRepository,
        private SeatRepository $seatRepository,
        private UserRepository $userRepository
    ) {}

    public function create(array $data): Ticket
    {
        $ticket = new Ticket();
        $ticket->setPrice($data['price']);
        $ticket->setStatus($data['status']);

        $session = $this->sessionRepository->find($data['session_id']);
        $seat = $this->seatRepository->find($data['seat_id']);
        $user = $this->userRepository->find($data['user_id']);

        $ticket->setSession($session);
        $ticket->setSeat($seat);
        $ticket->setUser($user);

        $this->em->persist($ticket);
        $this->em->flush();

        return $ticket;
    }
}
