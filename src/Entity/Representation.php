<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepresentationRepository")
 * @ORM\Table(name="representations")
 */
class Representation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Show", inversedBy="representations")
     * @ORM\JoinColumn(nullable=false, name="show_id", referencedColumnName="id")
     */
    private $the_show;

    /**
     * @ORM\Column(type="datetime", name="when")
     */
    private $the_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="representations")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $the_location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="representation")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheShow(): ?Show
    {
        return $this->the_show;
    }

    public function setTheShow(?Show $the_show): self
    {
        $this->the_show = $the_show;

        return $this;
    }

    public function getTheDate(): ?\DateTimeInterface
    {
        return $this->the_date;
    }

    public function setTheDate(\DateTimeInterface $the_date): self
    {
        $this->the_date = $the_date;

        return $this;
    }

    public function getTheLocation(): ?Location
    {
        return $this->the_location;
    }

    public function setTheLocation(?Location $the_location): self
    {
        $this->the_location = $the_location;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRepresentation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getRepresentation() === $this) {
                $reservation->setRepresentation(null);
            }
        }

        return $this;
    }
}
