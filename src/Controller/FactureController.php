<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Paiement;
use App\Form\Facture1Type;
use App\Repository\factureRepository;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer;
use Symfony\Component\Validator\Constraints\Email;
use App\Controller\MailerController;

#[Route('/facture')]
class FactureController extends AbstractController
{
    private \App\Controller\MailerController $mailerController;

    public function __construct(MailerController $mailerController)
    {
        $this->mailerController = $mailerController;
    }
    #[Route('/index', name: 'app_facture_index', methods: ['GET'])]
    public function index(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        $factures = $factureRepository->findAll();
        $factures = $paginator->paginate(
            $factures,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
        ]);
    }
    #[Route('/search', name: 'app_search', methods: ['GET'])]
    public function searchFacture(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        // Get the search query from the request
        $searchQuery = $request->query->get('query');

        // If there's no search query, fetch all records
        if (!$searchQuery) {
            $facturesQuery = $factureRepository->findAll();
        } else {
            // If there's a search query, perform the search
            $facturesQuery = $factureRepository->findByMultipleCriteria($searchQuery);
        }

        // Paginate the results
        $factures = $paginator->paginate(
            $facturesQuery,
            $request->query->getInt('page', 1), // Current page number
            10 // Number of items per page
        );

        return $this->render('facture/indexCOPIE.html.twig', [
            'factures' => $factures,
        ]);
    }
    #[Route('/indexC', name: 'app_facture_indexC', methods: ['GET'])]
    public function indexCopie(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        $factures = $factureRepository->findAll();
        $factures = $paginator->paginate(
            $factures,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('facture/indexCOPIE.html.twig', [
            'factures' => $factures,
        ]);
    }
/////////////////////////////////////search_app_repo
    #[Route('/search', name: 'app_facture_search', methods: ['GET'])]
    public function search(Request $request, FactureRepository $factureRepository)
    {
        // Get the search query from the request
        $query = $request->query->get('query');

        // Perform the search using the repository
        $factures = $factureRepository->findBySearchQuery($query);

        // Serialize the factures data
        $facturesData = [];
        foreach ($factures as $facture) {
            $facturesData[] = [
                'idFacture' => $facture->getIdFacture(),
                'libelle' => $facture->getLibelle(),
                // Add other properties as needed
            ];
        }

        // Return the search results as JSON
        return new JsonResponse(['factures' => $facturesData]);
    }


    #[Route('/indexFront', name: 'app_facture_indexFront', methods: ['GET'])]
    public function indexFront(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        $query = $factureRepository->createQueryBuilder('f')
            ->getQuery();

        $factures = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Notez la virgule ajoutée ici
            6 // Nombre d'éléments par page
        );

        return $this->render('facture/indexFront.html.twig', [
            'factures' => $factures
        ]);
    }

    #[Route('/Admin', name: 'app_Admin_index', methods:["GET"])]
    public function indexAdmin(Request $request, FactureRepository $factureRepository): Response
    {
        // Count of invoices for water type
        $countFactureEau = $factureRepository->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.type = :type')
            ->setParameter('type', 'EAU')
            ->getQuery()
            ->getSingleScalarResult();

        // Count of invoices for energy type
        $countFactureEnergie = $factureRepository->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.type = :type')
            ->setParameter('type', 'ENERGY')
            ->getQuery()
            ->getSingleScalarResult();
        $totalCount = $countFactureEau + $countFactureEnergie;

        return $this->render('Admin/index.html.twig', [
            'countFactureEau' => $countFactureEau,
            'countFactureEnergie' => $countFactureEnergie,
            'totalCount' => $totalCount, // Pass the total count to the template
        ]);
    }


    #[Route('/new', name: 'app_facture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ParameterBagInterface $parameterBag): Response
    {
        $facture = new Facture();
        $facture->setDate(new \DateTime()); //date bch tekhou date systeme fel création
        //date d'ech après 3 mois de la date de création
        $dateEcheance = new \DateTime();
        $dateEcheance->modify('+2 month');
        $facture->setDateEch($dateEcheance);


        $form = $this->createForm(Facture1Type::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            if($imageF = $form['imageF']->getData()){
                $photoDir = $parameterBag->get('photo_dir');
                $fileName = uniqid().'.'.$imageF->guessExtension();
                $imageF->move($photoDir, $fileName);
                $facture->setImageF($fileName);
            }
            $entityManager->persist($facture);
            $entityManager->flush();
            //$this->redirectToRoute('app_mail');
            $mailerController = new MailerController();
            $mailerController->sendEmail($facture);

            $this->mailerController->sendEmail($facture);

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{idFacture}/show', name: 'app_facture_show', methods: ['GET'])]
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }
    #[Route('/{idFacture}/showf', name: 'app_facture_showFront', methods: ['GET'])]
    public function showFront(Facture $facture): Response
    {
        return $this->render('facture/showFront.html.twig', [
            'facture' => $facture,
        ]);
    }

    #[Route('/{idFacture}/edit', name: 'app_facture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Facture1Type::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{idFacture}', name: 'app_facture_delete')]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        
            $entityManager->remove($facture);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/delete/{idFacture}', name: 'app_facture_deleteFront')]
    public function deleteFront(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($facture);
        $entityManager->flush();


        return $this->redirectToRoute('app_facture_indexFront', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/show', name: 'app_index', methods: ['GET'])]
    public function facture(factureRepository $factureRepository): Response
    {
        return $this->render('facture/indexFront.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    #[Route('/pdf/{idFacture}', name :'app_facture_pdf')]
    public function generatePDFfacture(Facture $facture, PdfService $pdfService): Response
    {
        $html = $this->renderView('facture/detailsPDF.html.twig', [
            'facture' => $facture,
        ]);

        // Get the PDF content from PdfService
        $pdfContent = $pdfService->showPdfFile($html);

        // Create a Response object with PDF content and headers
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
    #[Route('/search', name: 'app_facture_search', methods: ['GET'])]
    public function searchEvent(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        // Check if a search query is present
        $searchQuery = $request->query->get('query');

        // If there's no search query, fetch all records
        if (!$searchQuery) {
            $facturesQuery = $factureRepository->createQueryBuilder('f')->getQuery();
        } else {
            // If there's a search query, perform the search
            $facturesQuery = $factureRepository->findByMultipleCriteria($searchQuery);
        }

        // Paginate the results
        $factures = $paginator->paginate(
            $facturesQuery,
            $request->query->getInt('page', 1), // Current page number
            10 // Number of items per page
        );

        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
        ]);
    }






}
