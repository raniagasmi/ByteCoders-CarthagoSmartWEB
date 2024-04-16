<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Paiement;
use App\Form\Facture1Type;
use App\Repository\factureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/facture')]
class FactureController extends AbstractController
{
    #[Route('/index', name: 'app_facture_index', methods: ['GET'])]
    public function index(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        $factures = $factureRepository->findAll();
        $factures = $paginator->paginate(
            $factures,
            $request->query->getInt('page', 1), // Notez la virgule ajoutée ici
            10
        );
        
        return $this->render('facture/index.html.twig', [
            'factures' => $factures
        ]);
    }
    #[Route('/index', name: 'app_facture_indexFront', methods: ['GET'])]
    public function indexFront(Request $request, factureRepository $factureRepository, PaginatorInterface $paginator): Response
    {
        $factures = $factureRepository->findAll();
        $factures = $paginator->paginate(
            $factures,
            $request->query->getInt('page', 1), // Notez la virgule ajoutée ici
            10
        );

        return $this->render('facture/indexFront.html.twig', [
            'factures' => $factures
        ]);
    }

    #[Route('/Admin', name: 'app_Admin_index', methods:["GET"])]
    public function indexAdmin(): Response
    {
        return $this->render('Admin/index.html.twig');
    }

    #[Route('/new', name: 'app_facture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
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
    
            $entityManager->persist($facture);
            $entityManager->flush();

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


}
