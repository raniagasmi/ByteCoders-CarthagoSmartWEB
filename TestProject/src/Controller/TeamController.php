<?php

namespace App\Controller;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(): Response
    {
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
    #[Route('/addteam', name: 'addteam')]
    public function addteam(ManagerRegistry $managerRegistry): Response
    {
        $x = $managerRegistry->getManager();
        $team = new team();
        $team->setname("sarra");
        $team->setdescription("teamMember");
        


        $x->persist($team);
        $x->flush();
        return new Response(" great add");
    }
    #[Route('/showteam', name: 'showteam')]
    public function showteam(TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->findAll();
        return $this->render('team/showteam.html.twig', [
            'team' => $team
        ]);
    }
    #[Route('/addformteam', name: 'addformteam')]
    public function addformteam(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $x = $managerRegistry->getManager();
        $team = new team();
        $form = $this->createForm(teamType::class, $team);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($team);
            $x->flush();

            return $this->redirectToRoute('showteam');
        }
        return $this->renderForm('team/addformteam.html.twig', [
            'f' => $form
        ]);
    }
    #[Route('/editteam/{id}', name: 'editteam')]
    public function editteam($id, TeamRepository $teamRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        //var_dump($id) . die();
        $x = $managerRegistry->getManager();
        $dataid = $teamRepository->find($id);
        // var_dump($dataid) . die();
        $form = $this->createForm(teamType::class, $dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($dataid);
            $x->flush();
            return $this->redirectToRoute('showteam');}
        return $this->renderForm('team/editteam.html.twig', [
            'x' => $form
        ]);
    }  

    #[Route('/deleteteam/{id}', name: 'deleteteam')]
    public function deleteteam($id, ManagerRegistry $managerRegistry, TeamRepository $teamRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $teamRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('showstudent');
    }

}
