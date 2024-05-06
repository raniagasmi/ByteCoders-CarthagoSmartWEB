<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CollectdechetsRepository;
use App\Entity\Typedechets;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CollectdechetsRepository::class)]
class Collectdechets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCollect = null;

    #[Assert\NotBlank(message: "Veuillez saisir un point de ramassage.")]
    #[ORM\Column(length: 200, nullable: false)] // Assurez-vous que le champ peut être null dans la base de données
    private ?string $pointramassage;
    
    

    #[Assert\NotNull(message: "Veuillez choisir une date.")]
    #[ORM\Column(name: "DateRamassage", type: "date", nullable: true)]
    private ?\DateTimeInterface $dateramassage;
    
    #[Assert\NotNull(message:"Veuillez choisir un dechet.")]
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


    public function setPointramassage(?string $pointramassage): static
{
    $this->pointramassage = $pointramassage;

    return $this;
}


    public function getDateramassage(): ?\DateTimeInterface
    {
        return $this->dateramassage;
    }

    public function setDateramassage(?\DateTimeInterface $dateramassage): static
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
   

    // Dans votre entité Collectdechets

public function getLatitude(): ?float
{
    // Supposons que les coordonnées sont stockées sous forme de chaîne dans une colonne nommée "pointramassage"
    // Vous devrez extraire la latitude de cette chaîne
    $coordinates = $this->pointramassage;
    if ($coordinates) {
        $coords = explode(',', $coordinates);
        if (count($coords) === 2) {
            return floatval($coords[0]);
        }
    }
    return null;
}


}
