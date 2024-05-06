<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Service\SendMailService;
use App\Form\ResetPasswordFormType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;



class SecurityController extends AbstractController
{
    private $entityManager;

    public const SCOPES = [
        'google'=>[],
        //'github'=>['user:addEmail']
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



   #[Route(path: '/login', name: 'auth_oauth_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        if ($this->getUser()) {
            return new RedirectResponse($this->generateUrl('app_user_index'));
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

    }


    #[Route(path: '/logout', name: 'auth_oauth_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    #[Route(path: '/forgot', name: 'forgot')]
    public function forgotPassword(Request $request , UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator , EntityManagerInterface $entityManager ,MailerInterface $mailer,UrlGeneratorInterface $urlGenerator)
    {
        $form =$this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $donnees = $form->getData();
            $user = $userRepository->findOneBy(['addEmail'=>$donnees]);
            if(!$user)
            {
                $this->addFlash('danger','un probelem est survenu');
                return $this->redirectToRoute('forgot');  

            }
            $token = $tokenGenerator->generateToken();
               try{
                $user->setResetToken($token);
               // $entityManager->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

               }catch(\Exception $exception){

                $this->addFlash('danger','un probelem est survenu :' .$exception->getMessage());
                return $this->redirectToRoute('auth_oauth_login');
               }

               $resetUrl = $urlGenerator->generate('app_reset_password', array('token'=>$token), UrlGeneratorInterface::ABSOLUTE_URL);
               $email = (new TemplatedEmail())
               ->from('rania.gasmi@esprit.tn')
               ->to($user->getAddEmail())
               ->subject('Réinitialisation de mot de passe')
               ->html(
                   $this->renderView(
                       'emails/password_reset.html.twig',
                       ['resetUrl' => $resetUrl, 'user' => $user, 'url' => $resetUrl]
                   )
               );
               $mailer->send($email);  
               $this->addFlash('success', 'Mail sent succesufely');
            }
            return $this->render('security/reset_pass.html.twig', [
                'form' => $form->createView() 
            ]);
    
            }


     #[Route('/reset-password/reset/{token}', name: 'app_reset_password', methods: ['GET','POST'])]

    public function resetpassword(string $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['reset_token' => $token]);

        if ($user === null) {
            $this->addFlash('danger', 'TOKEN INCONNU');
            return $this->redirectToRoute('auth_oauth_login');
        }

        if ($request->isMethod('POST')) {
            $user->setResetToken(null);
            $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('password')));
            
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Mot de passe mis à jour :');
            return $this->redirectToRoute('auth_oauth_login');
        } else {
            return $this->render('security/reset.html.twig', ['token' => $token]);
        }
    }

    #[Route("/oauth/connect/{service}", name: 'auth_oauth_connect', methods: ['GET'])]
    public function connect(string $service, ClientRegistry $clientRegistry): RedirectResponse
    {
        if (! in_array($service, array_keys(self::SCOPES), true)) {
            throw $this->createNotFoundException();
        }

        return $clientRegistry
            ->getClient($service)
            ->redirect(self::SCOPES[$service],[]);
    }


    #[Route('/oauth/check/{service}', name: 'auth_oauth_check', methods: ['GET','POST'])]
    public function check(): Response{

        return new Response(200);
    }
    
        
}