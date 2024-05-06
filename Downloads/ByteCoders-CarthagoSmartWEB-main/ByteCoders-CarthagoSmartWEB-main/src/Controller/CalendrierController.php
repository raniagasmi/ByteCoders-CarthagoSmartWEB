<?php

namespace App\Controller;

use App\Repository\CollectdechetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    private $collectdechetsRepository;

    public function __construct(CollectdechetsRepository $collectdechetsRepository)
    {
        $this->collectdechetsRepository = $collectdechetsRepository;
    }

    #[Route('/Font/calendrier', name: 'app_calendrier', methods:['GET', 'POST'])]
    public function calendrier(): Response
    {
        // Récupérer les événements depuis la base de données
        $events = $this->collectdechetsRepository->findAll();

        // Rendre le template Twig avec les événements
        return $this->render('FrontS/calendrier.html.twig', [
            'events' => $events,
        ]);
    }



}
