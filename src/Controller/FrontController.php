<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\FactureController;
use App\Entity\Facture;
use App\Form\Facture1Type;

#[Route('/')]
class FrontController extends AbstractController
{
    #[Route('/accueil', name: 'app_front_accueil')]
    public function accueil(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/index', name: 'app_front_index')]
    public function index(): Response
    {
        return $this->render('facture/indexFront.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/service', name: 'app_front_service')]
    public function service(): Response
    {
        return $this->render('User/service.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/features', name: 'app_front_features')]
    public function features(): Response
    {
        return $this->render('User/feature.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/pricing', name: 'app_front_pricing')]
    public function pricing(): Response
    {
        return $this->render('User/pricing.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/blog', name: 'app_front_blog')]
    public function blog(): Response
    {
        return $this->render('User/blog.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/testimonial', name: 'app_front_testimonial')]
    public function testimonial(): Response
    {
        return $this->render('User/testimonial.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
