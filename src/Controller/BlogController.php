<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{


    //***********************************Admin start***********************************************************//
    /**
     * @Route("/", name="display_blog")
     */
    public function index(): Response
    {

        $blogs = $this->getDoctrine()->getManager()->getRepository(Blog::class)->findAll();
        return $this->render('blog/index.html.twig', [
            'b'=>$blogs
        ]);
    }



    /**
     * @Route("/admin", name="display_admin")
     */
    public function indexAdmin(): Response
    {

        return $this->render('Admin/index.html.twig' );
    }


   

  

  


}