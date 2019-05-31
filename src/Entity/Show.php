<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShowRepository")
 * @ORM\Table(name="shows")
 */
class Show
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster_url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="bookable")
     */
    private $location;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bookable;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Representation", mappedBy="the_show", orphanRemoval=true)
     */
    private $representations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ArtistType")
     */
    private $troupe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->representations = new ArrayCollection();
        $this->troupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPosterUrl(): ?string
    {
        return $this->poster_url;
    }

    public function setPosterUrl(?string $poster_url): self
    {
        $this->poster_url = $poster_url;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getBookable(): ?bool
    {
        return $this->bookable;
    }

    public function setBookable(bool $bookable): self
    {
        $this->bookable = $bookable;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Representation[]
     */
    public function getRepresentations(): Collection
    {
        return $this->representations;
    }

    public function addRepresentation(Representation $representation): self
    {
        if (!$this->representations->contains($representation)) {
            $this->representations[] = $representation;
            $representation->setTheShow($this);
        }

        return $this;
    }

    public function removeRepresentation(Representation $representation): self
    {
        if ($this->representations->contains($representation)) {
            $this->representations->removeElement($representation);
            // set the owning side to null (unless already changed)
            if ($representation->getTheShow() === $this) {
                $representation->setTheShow(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArtistType[]
     */
    public function getTroupe(): Collection
    {
        return $this->troupe;
    }

    public function addTroupe(ArtistType $troupe): self
    {
        if (!$this->troupe->contains($troupe)) {
            $this->troupe[] = $troupe;
        }

        return $this;
    }

    public function removeTroupe(ArtistType $troupe): self
    {
        if ($this->troupe->contains($troupe)) {
            $this->troupe->removeElement($troupe);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
