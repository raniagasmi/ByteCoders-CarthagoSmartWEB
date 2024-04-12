<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typedechets
 *
 * @ORM\Table(name="typedechets", indexes={@ORM\Index(name="fk_typeDechets_user", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\TypedechetsRepository")
 */
class Typedechets
{
    /**
     * @var int
     *
     * @ORM\Column(name="typeID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $typeid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=0, nullable=false)
     */
    private $categorie;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getTypeid(): ?int
    {
        return $this->typeid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getId(): ?User
    {
        return $this->id;
    }

    public function setId(?User $id): static
    {
        $this->id = $id;

        return $this;
    }


}
