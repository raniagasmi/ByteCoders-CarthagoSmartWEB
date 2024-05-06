<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class reclamationController extends AbstractController
{
    /**
     * @Route("/envoyer-mail", name="envoyer_mail", methods={"GET", "POST"})
     */
    public function envoyerMail(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class)
            ->add('sujet', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('message', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $sujet = $data['sujet'];
            $message = $data['message'];

            // Créez un nouvel e-mail
            $email = (new Email())
                ->from($email)
                ->to('sarra.rejeb@esprit.tn')
                ->subject($sujet)
                ->text($message);

            // Envoyer l'e-mail
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            return $this->redirectToRoute('envoyer_mail');
        }

        return $this->render('raclamation.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/LES_reclamation', name: 'app_reclamer', methods:["GET"])]
    public function reclamer(): Response
    {
        return $this->render('FrontS/LESreclamer.html.twig');
    }
}
