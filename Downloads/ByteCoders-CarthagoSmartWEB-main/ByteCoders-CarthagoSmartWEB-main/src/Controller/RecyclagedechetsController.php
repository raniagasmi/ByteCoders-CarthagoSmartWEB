<?php

namespace App\Controller;

use App\Entity\Recyclagedechets;
use App\Form\RecyclagedechetsType;
use App\Repository\RecyclagedechetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recyclagedechets')]
class RecyclagedechetsController extends AbstractController
{
    #[Route('/', name: 'app_recyclagedechets_index', methods: ['GET'])]
    public function index(RecyclagedechetsRepository $recyclagedechetsRepository): Response
    {
        return $this->render('recyclagedechets/index.html.twig', [
            'recyclagedechets' => $recyclagedechetsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recyclagedechets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recyclagedechet = new Recyclagedechets();
        $form = $this->createForm(RecyclagedechetsType::class, $recyclagedechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recyclagedechet);
            $entityManager->flush();

            return $this->redirectToRoute('app_recyclagedechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recyclagedechets/new.html.twig', [
            'recyclagedechet' => $recyclagedechet,
            'form' => $form,
        ]);
    }

    #[Route('/{idRecyc}', name: 'app_recyclagedechets_show', methods: ['GET'])]
    public function show(Recyclagedechets $recyclagedechet): Response
    {
        return $this->render('recyclagedechets/show.html.twig', [
            'recyclagedechet' => $recyclagedechet,
        ]);
    }

    #[Route('/{idRecyc}/edit', name: 'app_recyclagedechets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recyclagedechets $recyclagedechet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecyclagedechetsType::class, $recyclagedechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recyclagedechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recyclagedechets/edit.html.twig', [
            'recyclagedechet' => $recyclagedechet,
            'form' => $form,
        ]);
    }

    #[Route('/{idRecyc}', name: 'app_recyclagedechets_delete', methods: ['POST'])]
    public function delete(Request $request, Recyclagedechets $recyclagedechet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recyclagedechet->getIdRecyc(), $request->request->get('_token'))) {
            $entityManager->remove($recyclagedechet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recyclagedechets_index', [], Response::HTTP_SEE_OTHER);
    }

    private $recyclagedechetsRepository; // Assurez-vous que cette propriété est correctement définie

    public function __construct(RecyclagedechetsRepository $recyclagedechetsRepository)
    {
        $this->recyclagedechetsRepository = $recyclagedechetsRepository;
    }

     /**
     * @Route("/sort-by-cout", name="sort_by_cout")
     */
        public function sortByCout(): Response
        {
            // Implémentez la logique de tri par daterammasage et point ramassage ici, par exemple récupérez les événements triés depuis la base de données
            $events = $this->recyclagedechetsRepository->findBy([], ['id' => 'ASC','pointrecyclage' => 'ASC']);

            // Passez les résultats triés à votre modèle Twig pour l'affichage
            return $this->render('recyclagedechets/index.html.twig', [
                'events' => $events,
            ]);
        }
        #[Route('/search2', name: 'app_search2', methods: ['GET'])]
            public function searchEvent(Request $request, RecyclagedechetsRepository $recyclageRepository): Response
            {
                // Check if a search query is present
                $searchQuery = $request->query->get('query');
            
                // Initialize the variable
                $recyclagedechets = [];
            
                // If there's a search query, perform the search
                if ($searchQuery) {
                    $recyclagedechets = $recyclageRepository->findByMultipleCriteria($searchQuery);
                } else {
                    // If there's no search query, fetch all records
                    $recyclagedechets = $recyclageRepository->findAll();
                }
            
                return $this->render('recyclagedechets/index.html.twig', [
                    'recyclagedechets' => $recyclagedechets,
                ]);
            }
        
            }