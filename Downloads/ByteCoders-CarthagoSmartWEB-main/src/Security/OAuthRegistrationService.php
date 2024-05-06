<?php
namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use App\Form\UserType;


final class OAuthRegistrationService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


  /*  public function persist(ResourceOwnerInterface $resourceOwner): User
    {
        // Try to find user by email
        $user = $this->repository->findOneBy(['addEmail' => $resourceOwner->getEmail()]);

        // If user doesn't exist, create a new one
        if (!$user) {
            $user = (new User())
           // ->setAddEmail($resourceOwner->getEmail());
            // Set nom (last name) and prenom (first name)
            $nameParts = explode('@', $email);
            $nameParts = explode('.', $nameParts[0]);
            $user->setNom(ucfirst($nameParts[0]));
            $user->setPrenom(ucfirst($nameParts[1]));
            $user->setUsername($email);
            $password = bin2hex(random_bytes(8));
            $password = bin2hex(random_bytes(8)); // Generate a random password
            $user->setPassword($password);



        }

        // Google ID
        $user->setGoogle_Id($resourceOwner->getId());

        // Persist changes
        $this->repository->add($user, true);

        return $user;
    }*/


    /**
     * @param GoogleUser $resourceOwner
     */
    public function persist(ResourceOwnerInterface $resourceOwner): User
    {
        // Try to find user by email
        $user = $this->repository->findOneBy(['addEmail' => $resourceOwner->getEmail()]);

        // If user doesn't exist, create a new one
        if (!$user) {
            $user = new User();

            // Set nom (last name) and prenom (first name)
            $email = $resourceOwner->getEmail();
            $nameParts = explode('@', $email);
            $nameParts = explode('.', $nameParts[0]);
            $user->setNom(ucfirst($nameParts[0]));
            $user->setPrenom(ucfirst($nameParts[1]));
            $user->setUsername($email);
            
            // Set a suggested password (you can customize this logic)
            $password = bin2hex(random_bytes(8));
            $user->setPassword($password);
            
            // Set the email address
            $user->setAddEmail($email);

            // Other fields can be set as needed

            // Persist the user entity
            $this->repository->add($user, true);
        }

        // Google ID
        $user->setGoogle_Id($resourceOwner->getId());

        // Persist changes
        $this->repository->add($user, true);

        return $user;
    }


}

