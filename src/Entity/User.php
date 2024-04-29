<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use phpDocumentor\Reflection\Types\Static_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 



/**
 * User
 *
 * @ORM\Table(name="User", uniqueConstraints={@ORM\UniqueConstraint(name="addEmail", columns={"addEmail"})})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface , PasswordAuthenticatedUserInterface
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
 * @var int
 * 
 * @Assert\NotBlank(message="Ce champ doit contenir 8 chiffres")
 * @Assert\Length(
 *    exactMessage="Ce champ doit contenir exactement 8 chiffres",
 *    min=8,
 *    max=8
 * )
 * @ORM\Column(name="cin", type="integer", nullable=false)
 */
    private $cin;

/**
 * @var string
 * @Assert\NotBlank(message="Ce champ doit contenir votre nom")
 * @Assert\Length(
 *      min=3,
 *      max=15,
 *      maxMessage="Votre nom est trop long"
 * )
 * @ORM\Column(name="nom", type="string", length=255, nullable=false)
 */
private $nom;

    /**
     * @var string
     *   @Assert\NotBlank(message="ce champ doit contenir votre prenom")
     *   @Assert\Length(
     *      min = 3,
     *      max = 15,
     *      maxMessage = "votre prenom est trop long" )
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *  @Assert\NotBlank(message="ce champ doit contenir votre username")
     *  @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      maxMessage = "votre username est trop long" )
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numTlfn", type="integer", nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(
     * message = "The phone cannot be blank.",
     * groups = { "update_profile" }
     * )
     */
    private $numTlfn;

    /**
     * @var string
     *
     * @ORM\Column(name="addEmail", type="string", length=255, nullable=false)
     * @Assert\Email(
     *    message = "The email '{{ value }}' is not a valid email."
     * )
     * @Assert\NotBlank(
     *   message = "The email cannot be blank.",
     *   groups = {"registration", "login"}
     * )
     */
    private $addEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     */
    private $password;

     /**
     * @var string
     *
     * @ORM\Column(name="reset_token", type="string", length=255, nullable=false)
     */
    private $resetToken;


    /**
     * @var array|null
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @ORM\Column(name="roleUser", type="json", nullable=true)
     */
    private $roles = [];

    
    /**
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="user")
     */
    private $participants;


    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
     */
    private $messages;

    /**
     * @var string|null
     * @ORM\Column(name="urlImage", type="string", length=255, nullable=true)
     */
     private $urlImage;
     

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmationCode", type="string", length=255, nullable=true)
     */
    private $confirmationCode;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isVerified", type="boolean")
     */
    private $isVerified = false ;


    
    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /*private function generateVerificationCode(): string
    {
        $length = 6; // Length of the verification code
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $verificationCode = '';
        for ($i = 0; $i < $length; $i++) {
            $verificationCode .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $verificationCode;
    }
*/
    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getNumTlfn(): ?int
    {
        return $this->numTlfn;
    }


    public function setNumTlfn(?int $numTlfn): self
    {
        $this->numTlfn = $numTlfn;

        return $this;
    }

    public function getAddEmail(): ?string
    {
        return $this->addEmail;
    }

    public function setAddEmail(string $addEmail): self
    {
        $this->addEmail = $addEmail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
       /* $roles = $this->roles;
        
        $roles[] = 'ROLE_USER';

        return array_unique($roles);*/


        if (!is_array($this->roles)) {
            // Initialize $roles as an array with the existing value as its only element
            $roles = [$this->roles];
        } else {
            // Use the existing array
            $roles = $this->roles;
        }
        // Ensure uniqueness of roles and return
        return array_unique($roles);
    }

  /**
 * Sets the roles for the user.
 *
 * @param string[] $roles The roles to set for the user.
 * @return self
 */
public function setRoles(array $roles): self
{
    $this->roles = $roles;

    return $this;
}

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(?string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    public function setConfirmationCode(?string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function getSalt(): ?string
    {
        // Return salt here (or null if not needed)...
        return null;

    }

    public function eraseCredentials()
    {
        // Implement any necessary logic to erase sensitive data here...
    }


    public function __toString()
    {
        return $this->username;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

/*    public function isVerified(): bool
    {
        return $this->isVerified;
    }*/

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setUser($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getUser() === $this) {
                $participant->setUser(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }


}
