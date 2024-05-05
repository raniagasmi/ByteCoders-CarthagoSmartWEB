<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="fk_event_id", columns={"event_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @UniqueEntity(fields={"email"}, message="Cet e-mail est déjà utilisé.")
 */
class Reservation
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
     * @ORM\Column(name="email", type="string", length=255, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message="L'adresse email ne peut pas être vide.")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
     *     message="L'adresse email '{{ value }}' n'est pas valide."
     * )
     */
    private $email = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Le numéro doit contenir au moins {{ 8 }} caractères",
     *      maxMessage = "Le numéro ne peut pas contenir plus de {{ 8}} caractères"
     * )
     */
    private $numero = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbr_place", type="integer", nullable=true, options={"default"="NULL"})
     * @Assert\NotNull(message="Le nombre de places ne peut pas être vide.")
     * @Assert\PositiveOrZero(message="Le nombre de places doit être un nombre positif ou zéro.")
     */
    private $nbrPlace = NULL;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * })
     */
    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * })
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNbrPlace(): ?int
    {
        return $this->nbrPlace;
    }

    public function setNbrPlace(?int $nbrPlace): static
    {
        $this->nbrPlace = $nbrPlace;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
   

  


}
