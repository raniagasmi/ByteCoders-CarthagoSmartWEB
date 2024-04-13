<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecyclagedechetsRepository;
use App\Entity\Typedechets;

#[ORM\Entity(repositoryClass: RecyclagedechetsRepository::class)]
class Recyclagedechets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idRecyc = null;


    #[ORM\Column(length: 100)]
    private ?string $pointrecyclage = null;

    #[ORM\ManyToOne(inversedBy: 'recyclagedechets')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    private ?Typedechets $id = null;

    public function getIdRecyc(): ?int
    {
        return $this->idRecyc;
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

    public function getId(): ?Typedechets
    {
        return $this->id;
    }

    public function setId(?Typedechets $id): static
    {
        $this->id = $id;

        return $this;
    }


}
