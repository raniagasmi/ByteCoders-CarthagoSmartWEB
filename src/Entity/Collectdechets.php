<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Collectdechets
 *
 * @ORM\Table(name="collectdechets", indexes={@ORM\Index(name="fk_collectdechets_typeDechets", columns={"typeid"})})
 * @ORM\Entity
 */
class Collectdechets
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
     * @var string
     *
     * @ORM\Column(name="PointRamassage", type="string", length=100, nullable=false)
     */
    private $pointramassage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRamassage", type="date", nullable=false)
     */
    private $dateramassage;

    /**
     * @var \Typedechets
     *
     * @ORM\ManyToOne(targetEntity="Typedechets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeid", referencedColumnName="typeID")
     * })
     */
    private $typeid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointramassage(): ?string
    {
        return $this->pointramassage;
    }

    public function setPointramassage(string $pointramassage): static
    {
        $this->pointramassage = $pointramassage;

        return $this;
    }

    public function getDateramassage(): ?\DateTimeInterface
    {
        return $this->dateramassage;
    }

    public function setDateramassage(\DateTimeInterface $dateramassage): static
    {
        $this->dateramassage = $dateramassage;

        return $this;
    }

    public function getTypeid(): ?Typedechets
    {
        return $this->typeid;
    }

    public function setTypeid(?Typedechets $typeid): static
    {
        $this->typeid = $typeid;

        return $this;
    }


}
