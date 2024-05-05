<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaillingControllerTest extends WebTestCase
{
    // Méthode de test pour envoyer un e-mail
    public function testEnvoyerEmail()
    {
        // Créer un client pour simuler une requête HTTP
        $client = static::createClient();

        // Faire une requête POST vers l'URL de l'action envoyerEmail avec les données simulées
        $client->request('POST', '/envoyer-email', ['email' => 'recipient@example.com']);

        // Vérifier si la réponse est une redirection vers la page des réservations
        $this->assertTrue($client->getResponse()->isRedirect('/reservation/'));

        // Vérifier si l'e-mail a été envoyé avec les données attendues
        $emailCollector = $client->getProfile()->getCollector('mailer');
        $this->assertSame(1, $emailCollector->getMessageCount());

        $messages = $emailCollector->getMessages();
        $message = $messages[0];
        $this->assertInstanceOf(Email::class, $message);
        $this->assertSame('Confirmation de réservation', $message->getSubject());
        $this->assertSame('recipient@example.com', key($message->getTo()));
        $this->assertSame('Votre réservation a été confirmée.', $message->getTextBody());
    }
}
