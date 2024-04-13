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
}
