<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="fk_user", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\factureRepository")
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;

    /**
     * @var string|null
     *
     *@Assert\NotBlank(message="Le libelle est requis!")
     *
     * @ORM\Column(type="string", length=255) 
     */
    private $libelle;

    /**
     * @var \DateTimeInterface|null
     * @Assert\NotBlank(message="La date de création est requise !")
     *
     * @ORM\Column(name="date", type="date", nullable=true, options={"default"="NULL"})
     */
    private $date;

    /**
     * @var \DateTimeInterface|null
     * @Assert\NotBlank(message="La date d'échéance est requise!")
     * @Assert\GreaterThan(
     *     propertyPath="date",
     *     message="La date d'échéance doit être supérieure à la date de création."
     * )
     * @ORM\Column(name="date_ech", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateEch;

    /**
     * @var float|null
     *@Assert\NotBlank(message="Le montant est obligatoire !")
     * @Assert\Positive(message="Le montant doit être un nombre positif !")
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $montant;

    /**
     * @var string|null
     *@Assert\Choice(
     *     choices={"EAU", "ENERGY"},
     *     message="Veuillez sélectionner un type de facture parmi les options proposées."
     * )
     * @ORM\Column(name="type", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(name="imageF", type="string", length=255, nullable=true)
     */
    private $imageF;

    /**
     * @var bool|null
     * @Assert\NotNull(message="Veuillez préciser si la facture rest payée !")
     * @ORM\Column(name="estPayee", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $estpayee;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

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

    public function getDateEch(): ?\DateTimeInterface
    {
        return $this->dateEch;
    }

    public function setDateEch(?\DateTimeInterface $dateEch): static
    {
        $this->dateEch = $dateEch;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isEstpayee(): ?bool
    {
        return $this->estpayee;
    }

    public function setEstpayee(?bool $estpayee): static
    {
        $this->estpayee = $estpayee;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->getIdFacture();
    }

    public function getImageF(): ?string
    {
        return $this->imageF;
    }

    public function setImageF(?string $imageF): self
    {
        $this->imageF = $imageF;

        return $this;
    }


}
