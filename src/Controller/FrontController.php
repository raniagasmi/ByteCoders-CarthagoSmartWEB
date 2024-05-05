<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;


class FrontController extends AbstractController
{

    #[Route('/front', name: 'acceuil')]
    public function home(): Response
    {
        return $this->render('Front/index.html.twig');
    }

    #[Route('/front/event', name: 'app_event', methods:["GET"])]
    public function event(EventRepository $eventRepository): Response
    {
        return $this->render('Front/event.html.twig',[
            'events' => $eventRepository->findAll(),
        ]);
    }

}