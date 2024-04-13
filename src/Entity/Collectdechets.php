<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CollectdechetsRepository;
use App\Entity\Typedechets;

#[ORM\Entity(repositoryClass: CollectdechetsRepository::class)]
class Collectdechets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCollect = null;


    #[ORM\Column(length: 200)]
    private ?string $pointramassage = null;

    #[ORM\Column(name: "DateRamassage", type: "date", nullable: true, options: ["default" => "NULL"])]
    private ?\DateTimeInterface $dateramassage;

   
    #[ORM\ManyToOne(inversedBy: 'collectdechets')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    private ?Typedechets $id = null;

    public function getIdCollect(): ?int
    {
        return $this->idCollect;
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
