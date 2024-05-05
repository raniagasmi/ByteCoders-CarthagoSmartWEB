<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    
    
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    #[Route('/event/calendrier', name: 'app_calendrier', methods:['GET', 'POST'])]
    public function calendrier(): Response
    {
        // Récupérer les événements depuis la base de données
        $events = $this->eventRepository->findAll();

        // Rendre le template Twig avec les événements
        return $this->render('event/calendrier.html.twig', [
            'events' => $events,
        ]);
    }

}
