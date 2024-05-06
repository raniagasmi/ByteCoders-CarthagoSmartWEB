<?php

namespace App\Controller;


use App\Repository\CollectdechetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class mapcontroller extends AbstractController
{


private $collectdechetsRepository;

public function __construct(CollectdechetsRepository $collectdechetsRepository)
{
    $this->collectdechetsRepository = $collectdechetsRepository;
}

#[Route('/Font/map', name: 'app_map', methods:['GET', 'POST'])]
public function map(CollectdechetsRepository $collectdechetsRepository): Response
{
   // Récupérer les point de ramassage depuis la base de données
   $events = $collectdechetsRepository->findAll();

   // Rendre le template Twig avec les point de ramassage
   return $this->render('FrontS/map.html.twig', [
       'events' => $events,
   ]);
}



}