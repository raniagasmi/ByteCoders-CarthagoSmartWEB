<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/Admin', name: 'app_admin_index', methods:["GET"])]
    public function indexAdmin(): Response
    {
        return $this->render('Admin/index.html.twig');
    }

    #[Route('/event/like/{id}', name: 'event_like', methods: ['POST'])]
    public function likeEvent($id, EntityManagerInterface $em): Response
    {
        $event = $em->getRepository(Event::class)->find($id);
        if (!$event) {
            return new Response('Event not found', 404);
        }

        $event->setLikes($event->getLikes() + 1);
        $em->persist($event);
        $em->flush();

        return new Response('Like added', 200);
    }

    #[Route('/event/dislike/{id}', name: 'event_dislike', methods: ['POST'])]
    public function dislikeEvent($id, EntityManagerInterface $em): Response
    {
        $event = $em->getRepository(Event::class)->find($id);
        if (!$event) {
            return new Response('Event not found', 404);
        }

        $event->setDislikes($event->getDislikes() + 1);
        $em->persist($event);
        $em->flush();

        return new Response('Dislike added', 200);
    }


    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            if($image = $form['image']->getData()){
                $photoDir = $parameterBag->get('photo_dir');
                $fileName = uniqid().'.'.$image->guessExtension();
                $image->move($photoDir, $fileName);
                $event->setImage($fileName);
            }
            
            // Optional: send SMS with Twilio
            $twilioSid = 'AC0285b7d193c577bd0e20b3db225e3467';
            $twilioAuthToken = 'cde0ad3add97bbc45984c94703642859';
            $twilioPhoneNumber = '+21696171777';
            $twilio = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);
            $userPhoneNumber = '+21696171777';
            $twilio->messages->create(
            $userPhoneNumber,
            [
            "from" => '+13139241017',
            "body" => "New Event is created check it out {$event}"
            ]
            );
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/search_event", name="search_event")
     */
    public function searchEvent(Request $request, EventRepository $eventRepository): Response
    {
        $searchQuery = $request->query->get('query');
        
        // Appel de la méthode de recherche dans le repository
        $events = $eventRepository->findByMultipleCriteria($searchQuery);

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }
    public function sortByCout(): Response
    {
        // Implémentez la logique de tri par coût ici, par exemple récupérez les événements triés depuis la base de données
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['cout' => 'ASC']);

        // Passez les résultats triés à votre modèle Twig pour l'affichage
        return $this->render('event/sorted_by_cout.html.twig', [
            'events' => $events,
        ]);
    }
    
    
}
