<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallRepository::class)]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $numberOfRows;

    #[ORM\Column]
    private int $seatsPerRow;

    /**
     * @var Collection<int, Screening>
     */
    #[ORM\OneToMany(targetEntity: Screening::class, mappedBy: 'hall', orphanRemoval: true)]
    private Collection $screenings;

    public function __construct(string $name, int $numberOfRows, int $seatsPerRow)
    {
        $this->name = $name;
        $this->numberOfRows = $numberOfRows;
        $this->seatsPerRow = $seatsPerRow;
        $this->screenings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumberOfRows(): int
    {
        return $this->numberOfRows;
    }

    public function getSeatsPerRow(): int
    {
        return $this->seatsPerRow;
    }

    /**
     * @return Collection<int, Screening>
     */
    public function getScreenings(): Collection
    {
        return $this->screenings;
    }

    public function addScreening(Screening $screening): static
    {
        if (!$this->screenings->contains($screening)) {
            $this->screenings->add($screening);
            $screening->setHall($this);
        }

        return $this;
    }

    public function removeScreening(Screening $screening): static
    {
        if ($this->screenings->removeElement($screening)) {
            // set the owning side to null (unless already changed)
            if ($screening->getHall() === $this) {
                $screening->setHall(null);
            }
        }

        return $this;
    }
}
