<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Facture;
use App\Entity\User;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="fk_facture", columns={"id_facture"}), @ORM\Index(name="fk_user", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\paiementRepository")
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_paiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaiement;

    /**
     * @var float
     * @Assert\NotBlank(message="Vous devez saisir le montant à payer !")
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_paiement", type="string", length=300, nullable=false)
     */
    private $modePaiement;

    /**
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_facture", referencedColumnName="id_facture")
     * })
     */
    private $idFacture;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getIdPaiement(): ?int
    {
        return $this->idPaiement;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): Paiement
    {
        $this->montant = $montant;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): Paiement
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getIdFacture(): ?Facture
    {
        return $this->idFacture;
    }

    public function setIdFacture(?Facture $idFacture): Paiement
    {
        $this->idFacture = $idFacture;

        return $this;
    }

    public function getId(): ?User
    {
        return $this->id;
    }

    public function setId(?User $id): Paiement
    {
        $this->id = $id;

        return $this;
    }

    public function __toString(): string
    {
        return "Paiement ID: " . $this->getIdPaiement() . ", Facture ID: " . $this->getIdFacture() . ", User ID: " . $this->getId();
    }


}
