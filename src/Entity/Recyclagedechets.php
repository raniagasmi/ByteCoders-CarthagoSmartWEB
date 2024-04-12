<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recyclagedechets
 *
 * @ORM\Table(name="recyclagedechets", indexes={@ORM\Index(name="fk_recyclagedechets_typeDechets", columns={"typeid"})})
 * @ORM\Entity(repositoryClass="App\Repository\RecyclagedechetsRepository")
 */
class Recyclagedechets
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
     * @ORM\Column(name="PointRecyclage", type="string", length=100, nullable=false)
     */
    private $pointrecyclage;

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

    public function getPointrecyclage(): ?string
    {
        return $this->pointrecyclage;
    }

    public function setPointrecyclage(string $pointrecyclage): static
    {
        $this->pointrecyclage = $pointrecyclage;

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
