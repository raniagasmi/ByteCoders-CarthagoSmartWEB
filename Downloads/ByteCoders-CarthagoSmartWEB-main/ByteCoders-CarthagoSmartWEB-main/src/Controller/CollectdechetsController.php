<?php

namespace App\Controller;

use App\Entity\Collectdechets;
use App\Form\CollectdechetsType;
use App\Repository\CollectdechetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/collectdechets')]
class CollectdechetsController extends AbstractController
{
    #[Route('/', name: 'app_collectdechets_index', methods: ['GET'])]
    public function index(CollectdechetsRepository $collectdechetsRepository): Response
    {
        return $this->render('collectdechets/index.html.twig', [
            'collectdechets' => $collectdechetsRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_collectdechets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collectdechet = new Collectdechets();
        $form = $this->createForm(CollectdechetsType::class, $collectdechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collectdechet);
            $entityManager->flush();

            return $this->redirectToRoute('app_collectdechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collectdechets/new.html.twig', [
            'collectdechet' => $collectdechet,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idCollect}/edit', name: 'app_collectdechets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collectdechets $collectdechet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollectdechetsType::class, $collectdechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('app_collectdechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collectdechets/edit.html.twig', [
            'collectdechet' => $collectdechet,
            'form' => $form,
        ]);

    }
    
    
    #[Route('/{idCollect}', name: 'app_collectdechets_show', methods: ['GET'])]
    public function show(Collectdechets $collectdechet): Response
    {
        return $this->render('collectdechets/show.html.twig', [
            'collectdechet' => $collectdechet,
        ]);
    }


    #[Route('/{idCollect}', name: 'app_collectdechets_delete', methods: ['POST'])]
    public function delete(Request $request, Collectdechets $collectdechet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectdechet->getIdCollect(), $request->request->get('_token'))) {
            $entityManager->remove($collectdechet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collectdechets_index', [], Response::HTTP_SEE_OTHER);
    }

    
    private $collectdechetsRepository; // Assurez-vous que cette propriété est correctement définie

    public function __construct(CollectdechetsRepository $collectdechetsRepository)
    {
        $this->collectdechetsRepository = $collectdechetsRepository;
    }

    /**
     * @Route("/sort-by-cout", name="sort_by_cout")
     */
    public function sortByCout(): Response
    {
        // Implémentez la logique de tri par daterammasage et point ramassage ici, par exemple récupérez les événements triés depuis la base de données
        $events = $this->collectdechetsRepository->findBy([], ['dateramassage' => 'ASC','pointramassage' => 'ASC']);

        // Passez les résultats triés à votre modèle Twig pour l'affichage
        return $this->render('collectdechets/index.html.twig', [
            'events' => $events,
        ]);
    }

   
        #[Route('/search', name: 'app_search', methods: ['GET'])]
        public function searchEvent(Request $request, CollectdechetsRepository $collectRepository): Response
        {
            // Check if a search query is present
            $searchQuery = $request->query->get('query');
            
            // If there's no search query, fetch all records
            if (!$searchQuery) {
                $collectdechets = $collectRepository->findAll();
            } else {
                // If there's a search query, perform the search
                $collectdechets = $collectRepository->findByMultipleCriteria($searchQuery);
            }

            return $this->render('collectdechets/index.html.twig', [
                'collectdechets' => $collectdechets,
            ]);
        }





   
}
