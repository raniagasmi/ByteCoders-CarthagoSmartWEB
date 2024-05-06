<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use MercurySeries\FlashyBundle\FlashyNotifier;


class MailerControllerS extends AbstractController
{

    #[Route('/email1', name: 'app_mail1')]
    public function sendEmail1(MailerInterface $mailer, FlashyNotifier $flashy): Response
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Demande de Bac de TRI')
            ->text('Merci de m\'attribuer un bac de tri pour faciliter la gestion des déchets à mon domicile.');

        $mailer->send($email);

        $flashy->success('Email envoyé avec succès !');

    
        return $this->render('mailer/indexS.html.twig');
    }


    #[Route('/email2' , name:'app_mail2')]
    public function sendEmail2(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
           // ->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Réclamer une incivilité')
            ->text('Merci de prendre les mesures nécessaires pour résoudre rapidement la situation des déchets non conformes observés.');
            //->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...

        return $this->render('mailer/indexS.html.twig');
    }

    #[Route('/email3' , name:'app_mail3')]
    public function sendEmail3(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
           // ->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Ramassage dencombrement')
            ->text('Merci de coordonner le ramassage des objets encombrants devant ma résidence, selon les modalités prévues.');
            //->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...

        return $this->render('mailer/indexS.html.twig');
    }


}
