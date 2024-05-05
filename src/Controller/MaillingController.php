<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MaillingController extends AbstractController
{
    // Action pour traiter l'envoi d'e-mail
    public function envoyerEmail(Request $request, MailerInterface $mailer): Response
    {
        // Récupérer l'adresse e-mail du destinataire depuis la requête
        $email = $request->request->get('email');

        // Construire le contenu de l'e-mail
        $message = "Votre réservation a été confirmée.";

        // Créer l'e-mail
        $email = (new Email())
            ->from('cherifbenhassine@gmail.com') // Adresse e-mail de l'expéditeur
            ->to($email) // Adresse e-mail du destinataire
            ->subject('Confirmation de réservation') // Sujet de l'e-mail
            ->text($message); // Corps de l'e-mail

        // Envoyer l'e-mail
        $mailer->send($email);

        // Redirection vers une autre page ou affichage d'un message de confirmation
        // Par exemple, redirigez vers la liste des réservations avec un message flash
        $this->addFlash('success', 'L\'e-mail de confirmation a été envoyé.');

        // Redirection vers la page précédente (liste des réservations)
        return $this->redirectToRoute('app_reservation_index');
    }
}

