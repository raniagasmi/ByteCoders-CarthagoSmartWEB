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

    #[Route('/{idCollect}', name: 'app_collectdechets_show', methods: ['GET'])]
    public function show(Collectdechets $collectdechet): Response
    {
        return $this->render('collectdechets/show.html.twig', [
            'collectdechet' => $collectdechet,
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

    #[Route('/{idCollect}', name: 'app_collectdechets_delete', methods: ['POST'])]
    public function delete(Request $request, Collectdechets $collectdechet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectdechet->getIdCollect(), $request->request->get('_token'))) {
            $entityManager->remove($collectdechet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collectdechets_index', [], Response::HTTP_SEE_OTHER);
    }


   
}
