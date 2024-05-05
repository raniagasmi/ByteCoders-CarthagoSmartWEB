<?php

namespace App\Controller;

use App\Repository\factureRepository;
use FontLib\Table\Type\name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    #[Route('/search_ajax', name:"search", methods: ['GET'])]
    public function search(Request $request, factureRepository $factureRepository): \Symfony\Component\HttpFoundation\Response
    {
        $term = $request->query->get('term');

        // Recherchez les termes dans votre base de données
        $results = $factureRepository->findByTerm($term);

        // Formattez les résultats en JSON
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'libelle' => $result->getName(),
                'type' => $result->getCategorie(),
            ];
        }

        return new JsonResponse($formattedResults);
    }
    #[Route('/notif', name:"notif", methods: ['GET'])]
    public function notif(Request $request, factureRepository $factureRepository){
        return $this->render('user/notif.html.twig', [
            'controller_name' => 'SeacrhController',
        ]);
    }
}
