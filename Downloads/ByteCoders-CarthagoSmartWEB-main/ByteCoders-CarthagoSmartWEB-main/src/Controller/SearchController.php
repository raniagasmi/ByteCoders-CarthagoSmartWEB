<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypedechetsRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/search_ajax", name="search", methods={"GET"})
     */
    public function search(Request $request, TypedechetsRepository $typedechetRepository): JsonResponse
    {
        $term = $request->query->get('term');

        // Recherchez les termes dans votre base de données
        $results = $typedechetRepository->findByTerm($term);

        // Formattez les résultats en JSON
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = [
                'name' => $result->getName(),
                'categorie' => $result->getCategorie(),
            ];
        }

        return new JsonResponse($formattedResults);
    }
}
