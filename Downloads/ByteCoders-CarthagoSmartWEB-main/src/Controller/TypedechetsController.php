<?php

namespace App\Controller;

use App\Entity\Typedechets;
use App\Form\TypedechetsType;
use App\Repository\TypedechetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Util\Type;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/typedechets')]
class TypedechetsController extends AbstractController
{

    #[Route('/Admin', name: 'app_admin_index', methods:["GET"])]
    public function indexAdmin(Request $request, TypedechetsRepository $typeRepository): Response
    {
        // Count of invoices for water type
        $countRecyclable = $typeRepository->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.categorie = :categorie')
            ->setParameter('categorie', 'RECYCLABLE')
            ->getQuery()
            ->getSingleScalarResult();
    
        // Count of invoices for energy type
        $countNonRecyclable = $typeRepository->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.categorie = :categorie')
            ->setParameter('categorie', 'NON_RECYCLABLE')
            ->getQuery()
            ->getSingleScalarResult();
        $totalCount = $countRecyclable + $countNonRecyclable;
    
        return $this->render('Admin/index.html.twig', [
            'countRecyclable' => $countRecyclable, // Pass the countRecyclable to the template
            'countNonRecyclable' => $countNonRecyclable, // Pass the countNonRecyclable to the template
            'totalCount' => $totalCount, // Pass the total count to the template
        ]);
    }
    



    #[Route('/', name: 'app_typedechets_index', methods: ['GET'])]
    public function index(Request $request,TypedechetsRepository $typedechetsRepository,PaginatorInterface $paginator): Response
    {
        $typedechets = $typedechetsRepository->findAll();
        $typedechets = $paginator->paginate(
            $typedechets,
            $request->query->getInt('page', 1), // Notez la virgule ajoutée ici
            10
        );
        
        
        return $this->render('typedechets/index.html.twig', [
            'typedechets' => $typedechets,
        ]);
    }

    #[Route('/new', name: 'app_typedechets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typedechet = new Typedechets();
        $form = $this->createForm(TypedechetsType::class, $typedechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typedechet);
            $entityManager->flush();

            return $this->redirectToRoute('app_typedechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typedechets/new.html.twig', [
            'typedechet' => $typedechet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typedechets_show', methods: ['GET'])]
    public function show(Typedechets $typedechet): Response
    {
        // Utilisez directement l'objet Typedechets récupéré par le ParamConverter
        return $this->render('typedechets/show.html.twig', [
            'typedechet' => $typedechet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typedechets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typedechets $typedechet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypedechetsType::class, $typedechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_typedechets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typedechets/edit.html.twig', [
            'typedechet' => $typedechet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typedechets_delete', methods: ['POST'])]
    public function delete(Request $request, Typedechets $typedechet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typedechet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typedechet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_typedechets_index', [], Response::HTTP_SEE_OTHER);
    }
    private $typedechetsRepository; // Assurez-vous que cette propriété est correctement définie

    public function __construct(TypedechetsRepository $typedechetsRepository)
    {
        $this->typedechetsRepository = $typedechetsRepository;
    }

     /**
     * @Route("/sort-by-cout", name="sort_by_cout")
     */
        public function sortByCout(): Response
        {
            // Implémentez la logique de tri par daterammasage et point ramassage ici, par exemple récupérez les événements triés depuis la base de données
            $events = $this->typedechetsRepository->findBy([], ['id' => 'ASC','name' => 'ASC','categorie' => 'ASC']);

            // Passez les résultats triés à votre modèle Twig pour l'affichage
            return $this->render('typedechets/index.html.twig', [
                'events' => $events,
            ]);
        }
        

        #[Route('/search3', name: 'app_search3', methods: ['GET'])]
            public function searchEvent(Request $request, TypedechetsRepository $typedechetsRepository): Response
            {
                // Check if a search query is present
                $searchQuery = $request->query->get('query');
            
                // Initialize the variable
                $typedechets = [];
            
                // If there's a search query, perform the search
                if ($searchQuery) {
                    
                    $typedechets = $typedechetsRepository->findByMultipleCriteria($searchQuery);
                } else {
                    // If there's no search query, fetch all records
                    $typedechets = $typedechetsRepository->findAll();
                }
            
                return $this->render('typedechets/index.html.twig', [
                    'typedechets' => $typedechets,
                ]);
            }

            /**
             * @Route("/filter", name="app_typedechets_filter", methods={"POST"})
             */
            public function filter(Request $request, TypedechetsRepository $typedechetsRepository): JsonResponse
            {
                // Récupérer la catégorie sélectionnée depuis la requête
                $category = $request->request->get('category');

                // Requête pour récupérer les déchets filtrés par catégorie
                $typedechets = $typedechetsRepository->findBy(['categorie' => $category]);

                // Rendre la réponse JSON avec les déchets filtrés
                return new JsonResponse(['typedechets' => $typedechets]);
            }

            

}
