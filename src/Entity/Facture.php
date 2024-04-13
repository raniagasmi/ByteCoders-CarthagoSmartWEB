<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $libelle = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true, options={"default"="NULL"})
     */
    private $date = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_ech", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateEch = 'NULL';

    /**
     * @var float|null
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $montant = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $type = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estPayee", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $estpayee = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $idUser = NULL;

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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }


}
