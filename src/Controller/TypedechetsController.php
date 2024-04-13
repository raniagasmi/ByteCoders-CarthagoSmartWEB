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

#[Route('/typedechets')]
class TypedechetsController extends AbstractController
{

    #[Route('/Admin', name: 'app_admin_index', methods:["GET"])]
    public function indexAdmin(): Response
    {
        return $this->render('Admin/index.html.twig');
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
}
