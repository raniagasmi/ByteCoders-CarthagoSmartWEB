<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\RegistrationController;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\AdminUserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Service\SmSGenerator;




#[Route('/user')]
class UserController extends AbstractController
{

    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    
    #[Route('/forUser', name: 'app_user_forUser')]
    public function indexUser(): Response
    {

        return $this->render('user/forUser.html.twig');
    }

    #[Route('/contact', name: 'app_user_contact')]
    public function indexContact(): Response
    {
        return $this->render('user/contact.html.twig');
    }

    #[Route('/{id}/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('user/profile.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/profileb', name: 'app_profileb', methods: ['GET', 'POST'])]
    public function profileb(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('user/editAdmin.html.twig', [
            'user' => $this->getUser(),
            'formB' => $form->createView(),
        ]);
    }




   /* #[Route('/profile/{id}/edit', name: 'profile_edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, $id)
    {
        // Récupérer l'utilisateur à partir de son ID
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }

        // Créer le formulaire de type ProfileFormType et associer les données de l'utilisateur
        $form = $this->createForm(ProfileFormType::class, $user);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mettre à jour les données de l'utilisateur dans la base de données
            $this->entityManager->flush();

            // Rediriger l'utilisateur vers une autre page après la soumission du formulaire
            return $this->redirectToRoute('profile_show', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

    #[Route('/profile/edit', name: 'profile_edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager): Response
    {
        // Get the current user
        $user = $this->getUser();   
    
        // Determine the appropriate form type based on the user's role
        if (in_array('ADMIN', $user->getRoles(), true) ||
            in_array('ROLE_RESPONSABLE_ENERGIES', $user->getRoles(), true) ||
            in_array('ROLE_RESPONSABLE_DECHETS', $user->getRoles(), true) ||
            in_array('ROLE_RESPONSABLE_EVENEMENTS', $user->getRoles(), true)) {
            // Redirect to profileb action for admins or responsible users
            return $this->redirectToRoute('app_profileb', ['id' => $user->getId()]);
        } else {
            // Redirect to profile action for regular users
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }
    }
    
   /* #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }*/

#[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
public function edit(int $id, Request $request, User $user, EntityManagerInterface $entityManager, UserRepository $repository): Response
{

    $accountSid = 'AC8fe4189d97ce1138df7b1e66648ed1b5';
    $authToken = '5b73bfc54665b945bb177d82a4d0b25e';
    $fromNumber = '+13193132310';

    $user = $repository->find($id);
    if ($user === null) {
        throw $this->createNotFoundException('User not found.');
    }
    
    // Instantiate SmSGenerator service with required arguments
    $smsGenerator = new SmSGenerator($accountSid, $authToken, $fromNumber);
    
    $form = $this->createForm(AdminUserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->entityManager;
        $entityManager->flush();

        // Use the instantiated SmSGenerator service
        $smsGenerator->sendSms($user->getNumTlfn(), $user->getNom(), "Your CarthagoSmart account has been blocked.");
        
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('user/edit.html.twig', [
        'user' => $user,
        'form' => $form,
    ]);
}


/**
 * @Route("/sort-users", name="sort_users")
 */
public function sortUsers(Request $request): Response
{
    $criteria = $request->query->get('criteria', 'status');

    // Your logic to retrieve data and sort based on the criteria
    $users = $this->entityManager->getRepository(User::class)->findBy([], [$criteria => 'ASC']);

    // Extract user data to an array
    $userData = [];
    foreach ($users as $user) {
        $userData[] = [
            'urlImage' => $user->getUrlImage(), // Include the urlImage property
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'username' => $user->getUsername(),
            'numTlfn' => $user->getNumTlfn(),
            'addEmail' => $user->getAddEmail(),
            'roles' => $user->getRoles(),
            'status' => $user->getStatus(),
            'isVerified' => $user->getIsVerified(),
            // Add more user properties as needed
        ];
    }

    // Return JSON response containing sorted user data
    return new JsonResponse(['users' => $userData]);
}

}
