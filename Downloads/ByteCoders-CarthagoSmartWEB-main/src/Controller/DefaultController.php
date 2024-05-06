<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface; // Import the EntityManagerInterface


class DefaultController extends AbstractController

{

    private $entityManager; // Declare the EntityManager

    public function __construct(EntityManagerInterface $entityManager) // Inject the EntityManager
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/search", name="ajax_search", methods={"GET"})
     */
    public function searchAction(Request $request): Response
    {
        $requestString = $request->query->get('q');

        $users = $this->entityManager->getRepository(User::class)->findUsersByString($requestString);

       if (!$users) {
            $result['users']['error'] = "No entries found";
        } else {
            $result['users'] = $this->getRealEntities($users);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($users): array
    {
        $realEntities = [];

        foreach ($users as $user) {
            // Modify according to your User entity fields
            $realEntities[$user->getId()] = [
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'username' => $user->getUsername(),
                'numTlfn' => $user->getNumTlfn(),
                'addEmail' => $user->getAddEmail(),
                'roles' => $user->getRoles(),
                'status' => $user->getStatus(),
                'isVerified' => $user->getIsVerified(),
                // Add more fields as needed
            ];
        }

        return $realEntities;
    }
}
