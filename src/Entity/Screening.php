<?php

namespace App\Entity;

use App\Repository\ScreeningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreeningRepository::class)]
class Screening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'screenings')]
    #[ORM\JoinColumn(nullable: false)]
    private Hall $hall;

    #[ORM\ManyToOne(inversedBy: 'screenings')]
    #[ORM\JoinColumn(nullable: false)]
    private Movie $movie;

    #[ORM\Column]
    private \DateTimeImmutable $startTime;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'screening')]
    private Collection $reservations;

    public function __construct(Hall $hall, Movie $movie, \DateTimeImmutable $startTime)
    {
        $this->hall = $hall;
        $this->movie = $movie;
        $this->startTime = $startTime;
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHall(): Hall
    {
        return $this->hall;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setHall(?Hall $hall): static
    {
        $this->hall = $hall;
        return $this;
    }

    public function setMovie(?Movie $movie): static
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setScreening($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getScreening() === $this) {
                $reservation->setScreening(null);
            }
        }

        return $this;
    }
}
