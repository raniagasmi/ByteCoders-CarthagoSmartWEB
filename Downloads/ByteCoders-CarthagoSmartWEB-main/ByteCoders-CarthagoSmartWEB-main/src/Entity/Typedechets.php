<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypedechetsRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TypedechetsRepository::class)]
class Typedechets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: "Veuillez saisir le nom de votre déchet.")]
    #[ORM\Column(length: 200, nullable: false)] // Assurez-vous que le champ peut être null dans la base de données
    private ?string $name;

    #[Assert\NotNull(message:"Veuillez choisir une categorie.")]
    #[ORM\Column(length: 100)]
    private ?string $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(?string $name): static
    {
        $this->name = $name;
    
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }


    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    public function __toString(): string
    {
        return $this->name; // Retourne le nom de l'entité Typedechets
    }

    


}
