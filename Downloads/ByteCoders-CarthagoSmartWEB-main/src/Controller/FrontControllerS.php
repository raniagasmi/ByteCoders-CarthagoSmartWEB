<?php

namespace App\Controller;

use App\Entity\Collectdechets;
use App\Repository\CollectdechetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class FrontControllerS extends AbstractController
{

    #[Route('/Front', name: 'acceuil', methods:["GET"])]
    public function home(): Response
    {
        return $this->render('FrontS/index.html.twig');
    }

    #[Route('/Front/AcceuilDechets', name: 'app_AcceuilDechets', methods:["GET"])]
    public function AcceuilDechets(): Response
    {
        return $this->render('FrontS/AcceuilDechets.html.twig');
    }


     #[Route('/Front/recyclage', name: 'app_recyclage', methods:["GET"])]
    public function recyclage(): Response
    {
        return $this->render('FrontS/recyclage.html.twig');
    }

    #[Route('/Front/ramassage', name: 'app_ramassage', methods:["GET"])]
    public function ramassage(): Response
    {
        return $this->render('FrontS/ramassage.html.twig');
    }
    #[Route('/Front/service', name: 'app_service', methods:["GET"])]
    public function service(): Response
    {
        return $this->render('FrontS/service.html.twig');
    }


    #[Route('/Front/map', name: 'app_map', methods:["GET"])]
    public function map(): Response
    {
        return $this->render('FrontS/map.html.twig');
    }

   /*#[Route('/Front/calendrier', name: 'app_calendrier', methods:['GET', 'POST'])]
    private $doctrine;
    public function calendrier(): Response
    {
        return $this->render('Front/calendrier.html.twig');
        // Récupérer les événements depuis la base de données
        $events = $this->doctrine->getRepository->getDateramassage(Collectdechets::class)->findAll();
        

        // Rendre le template Twig avec les événements
        return $this->render('Front/calendrier.html.twig', [
            'events' => $events,
        ]);
    }*/
   
}