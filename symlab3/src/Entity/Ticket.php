<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['new', 'paid', 'cancelled'])]
    private ?string $status = null;

    #[ORM\ManyToOne]
    #[Assert\NotNull]
    private ?Session $session = null;

    #[ORM\ManyToOne]
    #[Assert\NotNull]
    private ?Seat $seat = null;

    #[ORM\ManyToOne]
    #[Assert\NotNull]
    private ?User $user = null;
}
