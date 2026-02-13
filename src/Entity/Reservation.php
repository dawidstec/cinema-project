<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private Screening $screening;

    #[ORM\Column]
    private int $rowNumber;

    #[ORM\Column]
    private int $seatNumber;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct(Screening $screening, int $rowNumber, int $seatNumber, ?\DateTimeImmutable $createdAt = null)
    {
        $this->screening = $screening;
        $this->rowNumber = $rowNumber;
        $this->seatNumber = $seatNumber;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScreening(): Screening
    {
        return $this->screening;
    }

    public function setScreening(?Screening $screening): static
    {
        $this->screening = $screening;

        return $this;
    }

    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    public function getSeatNumber(): int
    {
        return $this->seatNumber;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
