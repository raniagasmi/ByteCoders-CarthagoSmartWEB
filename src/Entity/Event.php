<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @UniqueEntity(fields={"nomEvent"}, message="Ce nom d'événement est déjà utilisé.")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_event", type="string", length=255, nullable=true)
     */
    private $nomEvent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="heure", type="time", nullable=true)
     */
    private $heure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

     /**
     * @var int|null
     *
     * @ORM\Column(name="capacite", type="integer", nullable=true)
     * @Assert\NotNull(message="La capacité ne peut pas être vide.")
     * @Assert\GreaterThan(value=100, message="La capacité doit être supérieure à 100.")
     */
    private $capacite;

  /**
     * @var float|null
     *
     * @ORM\Column(name="cout", type="float", nullable=true)
     * @Assert\NotNull(message="Le coût ne peut pas être vide.")
     * @Assert\GreaterThanOrEqual(value=0, message="Le coût ne peut pas être négatif.")
     */
    private $cout;

    /**
     * @var string|null
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Likes cannot be negative.")
     */
    private $likes = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="dislikes", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0, message="Dislikes cannot be negative.")
     */
    private $dislikes = 0;

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(?int $dislikes): static
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    public function setNomEvent(?string $nomEvent): static
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(?string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function setDate(?DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(?float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }
    public function __toString()
    {
        return $this->nomEvent;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


}
