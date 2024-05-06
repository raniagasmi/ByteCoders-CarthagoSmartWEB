<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Service\PdfService;
use App\Service\StripeService;
use App\Entity\Facture;
use App\Entity\User;
use App\Form\PaiementType;
use App\Repository\paiementRepository;
use App\Controller\FactureController;
use App\Repository\factureRepository;
use App\Repository\userRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/paiement')]
class PaiementController extends AbstractController
{
    #[Route('/index', name: 'app_paiement_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($paiement);
            $entityManager->flush();
            return $this->redirectToRoute('app_paiement_index');
        }

        return $this->render('paiement/index.html.twig', [
            'paiementForm' => $form->createView(),
        ]);
    }

    /*
    #[Route('/{idPaiement}', name: 'app_paiement_show', methods: ['GET'])]
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }


    #[Route('/{idPaiement}/edit', name: 'app_paiement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'paiementForm' => $form,
        ]);
    }

    #[Route('/{idPaiement}', name: 'app_paiement_delete', methods: ['POST'])]
    public function delete(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getIdPaiement(), $request->request->get('_token'))) {
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    }

    */

    #[Route('/stripe', name: 'app_paiement_stripe', methods: ['GET', 'POST'])]
    public function payment(Request $request, StripeService $stripeService): Response
    {
        if ($request->isMethod('POST')){
            $amount = $request->request->get('amount'); //bch njibou l amount mel form
            //l creation mtaa charge using the Stripe service
            $charge = $stripeService->createCharge([
                'amount' => $amount,
                'currency' => 'tnd',
                'source' => $request->request->get('stripeToken'), //token obtenu par Stripe.js
                'description' => 'Example charge',
            ]);
            //si charge est successful wala failed
            if($charge->status === 'succeeded') {
                $this->addFlash('success', 'paiement effectué');
            } else {
                $this->addFlash('error', 'Paiement échoué. Veuillez réessayer!');
            }

            return $this->redirectToRoute('payment');
        }
        return $this->render('paiement/paiement.html.twig');
    }


    #[Route('/{idFacture}/new', name: 'app_paiement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FactureRepository $factureRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {

        // Fetch necessary data from the database
        $idFacture = $request->attributes->getInt('idFacture');
        //$id = $request->query->getInt('id');
        $facture = $factureRepository->find($idFacture);
        //$user = $userRepository->find($id);



        //if (!$facture || !$user) {
        // check here if the facture belongs to the user



        if (!$facture) {
            throw $this->createNotFoundException('Facture not found');
        }

        $paiement = new Paiement();

        $paiement->setIdFacture($facture);
        //$paiement->setId($user) ?? null;
        $montant = $facture->getMontant();
        $paiement->setMontant($montant);

        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paiement);
            $entityManager->flush();
            return $this->redirectToRoute('app_paiement_new', ['idFacture' => $idFacture]);
        }

        return $this->render('paiement/new.html.twig', [
            'paiementForm' => $form->createView(),
        ]);
    }


    #[Route('/{idFacture}/checkout', name: 'checkout')]
    public function checkout(Request $request, EntityManagerInterface $entityManager, $stripeSK): Response
    {
        //$paiement = new Paiement();
        //$facture = new Facture();
        $idFacture = $request->attributes->getInt('idFacture');
        $facture = $entityManager->getRepository(Facture::class)->find($idFacture);
        //$facture = $paiement->getIdFacture();
        Stripe::setApiKey($stripeSK);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $facture->getLibelle(),
                        ],
                        'unit_amount'  => $facture->getMontant()*100,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', ['idFacture' => $facture->getIdFacture()], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);


        return $this->redirect($session->url, 303);
    }

    #[Route('/{idFacture}/success-url', name: 'success_url')]
    public function successUrl(EntityManagerInterface $entityManager, Request $request, SessionInterface $session, PdfService $pdfService): Response
    {
        $idFacture = $request->attributes->getInt('idFacture');
        $factureRepository = $entityManager->getRepository(Facture::class);
        $facture = $factureRepository->find($idFacture);

        /*if (!$facture) {
            throw $this->createNotFoundException('Facture non trouvée.');
        }*/

        // Appel de la méthode handleSuccessfulPayment pour mettre à jour la facture
        $this->handleSuccessfulPayment($facture, $entityManager);
        $session->set('payment_success', true);

        return $this->render('paiement/success.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }

    // Méthode pour mettre à jour la propriété estpayee d'une facture
    public function handleSuccessfulPayment(Facture $facture, EntityManagerInterface $entityManager): void
    {
        // Mettre à jour la valeur de estPayee
        $facture->setEstpayee(true);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();
    }


    // Méthode pour mettre à jour la propriété estpayee d'une facture
    /*private function handleSuccessfulPayment(Facture $facture, EntityManagerInterface $entityManager): void
    {
        // Mettre à jour la valeur de estPayee
        $facture->setEstpayee(true);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();
    }
}*/
    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl() : Response
    {
        return $this->render('paiement/cancel.html.twig',
            ['controller_name' => 'PaiementController',]);
    }


}
