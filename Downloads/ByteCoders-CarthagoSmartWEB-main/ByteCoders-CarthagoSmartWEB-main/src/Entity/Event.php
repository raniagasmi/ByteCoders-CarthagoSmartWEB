<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
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
     * @ORM\Column(name="nom_event", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nomEvent = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $categorie = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true, options={"default"="NULL"})
     */
    private $date = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="heure", type="time", nullable=true, options={"default"="NULL"})
     */
    private $heure = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $lieu = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="capacite", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $capacite = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="cout", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $cout = NULL;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): static
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


}
