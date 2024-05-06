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




#[Route('/admin')]
class AdminController extends AbstractController
{

    
    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/users', name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request , UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
       // Get your data, for example from repository
    $usersQuery = $userRepository->findAll();

    // Paginate the data
    $users = $paginator->paginate(
        $usersQuery,
        $request->query->getInt('page', 1), // Current page number, default 1
        10 // Number of items per page
    );

    // Count the total number of results
    $totalItemCount = $users->getTotalItemCount();

    return $this->render('user/index.html.twig', [
        'users' => $users,
        'totalItemCount' => $totalItemCount, // Pass the total count to the template
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