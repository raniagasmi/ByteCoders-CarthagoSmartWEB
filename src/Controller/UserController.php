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



#[Route('/user')]
class UserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }




    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request , UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findAll();
        $users =  $paginator->paginate(
            $users ,
            $request->query->getInt('page', 1), // Notez la virgule ajoutée ici
            10
        );
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/home', name: 'app_user_home')]
    public function indexHome(): Response
    {

        return $this->render('Home/index.html.twig');
    }

    #[Route('/forUser', name: 'app_user_forUser')]
    public function indexUser(): Response
    {

        return $this->render('user/forUser.html.twig');
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


    #[Route('/profile/{id}/edit', name: 'profile_edit', methods: ['GET', 'POST'])]
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
    }



   
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(int $id, UserRepository $userRepository): Response
    {
    $userRepository = $this->entityManager->getRepository(User::class);  
    $id = (int) $id; // Convert the string ID to an integer
    $user = $userRepository->find($id); // Replace $userId with the actual ID of the user you want to retrieve
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }
    return $this->render('user/show.html.twig', [
        'user' => $user,
    ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
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
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
