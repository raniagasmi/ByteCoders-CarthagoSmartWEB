<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Form\PlayerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/player', name: 'app_player')]
    public function index(): Response
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }
    #[Route('/addplayer', name: 'addplayer')]
    public function addplayer(ManagerRegistry $managerRegistry): Response
    {
        $x = $managerRegistry->getManager();
        $player = new player();
        $player->setusername("sarra");
        $player->setbirthday("2001-02-27");
        


        $x->persist($player);
        $x->flush();
        return new Response(" great add");
    }

    #[Route('/showplayer', name: 'showplayer')]
    public function showplayer(PlayerRepository $playerRepository): Response
    {
        $player = $playerRepository->findAll();
        return $this->render('player/showplayer.html.twig', [
            'player' => $player
        ]);
    }
    #[Route('/addformplayer', name: 'addformplayer')]
    public function addformplayer(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $x = $managerRegistry->getManager();
        $player = new player();
        $form = $this->createForm(playerType::class, $player);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($player);
            $x->flush();

            return $this->redirectToRoute('showplayer');
        }
        return $this->renderForm('player/addformplayer.html.twig', [
            'f' => $form
        ]);
    }

    #[Route('/editplayer/{id}', name: 'editplayer')]
    public function editplayer($id, PlayerRepository $playerRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        //var_dump($id) . die();
        $x = $managerRegistry->getManager();
        $dataid = $playerRepository->find($id);
        // var_dump($dataid) . die();
        $form = $this->createForm(playerType::class, $dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($dataid);
            $x->flush();
            return $this->redirectToRoute('showplayer');}
        return $this->renderForm('player/editplayer.html.twig', [
            'x' => $form
        ]);
    }  

    #[Route('/deleteplayer/{id}', name: 'deleteplayer')]
    public function deleteplayer($id, ManagerRegistry $managerRegistry, PlayerRepository $playerRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $playerRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('showplayer');
    }

    
}
