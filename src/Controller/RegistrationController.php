<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Controller\UserController;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\SendMailService;
use App\Service\JWTService;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\PasswordUpgradeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\AuthenticatedBadge;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



class RegistrationController extends AbstractController
{
    
   /* private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }*/

   /* #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager , SendMailService $mail , JWTService $jwt): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
          /*  $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('rania.gasmi@esprit.tn', 'NoReply'))
                    ->to($user->getAddEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );*/
            // do anything else you need here, like send an email

         // genreate jwt for user 
            // create header 

           /* $header = ['typ' =>'jwt', 'alg' =>'HS256'];

            $payload = ['user_id' => $user->getId()];

            // genrate token 
            $token = $jwt->generate($header , $payload , $this->getParameter('app.jwtsecret'));

            
            /*$mail->send(
                'no-reply@monsite.net',
                $user->getAddEmail(),
                'Activation de votre compte sur le site CarthagoSmart',
                'register',
                compact('user' , 'token')
            );*/

         /*   $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('rania.gasmi@esprit.tn', 'NoReply'))
                ->to($user->getAddEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
            return $this->redirectToRoute('app_login');
        }
           /* return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }*/

     /*   return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }*/


    /*private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }*/

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager ,ParameterBagInterface $parameterBag, UserRepository $userRepository, VerifyEmailHelperInterface $verifyEmailHelper,MailerInterface $mailer ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if($urlImage = $form['urlImage']->getData()){
                $photoDir = $parameterBag->get('photo_dir');
                $fileName = uniqid().'.'.$urlImage->guessExtension();
                $urlImage->move($photoDir, $fileName);
                $user->setUrlImage($fileName);
            }

            $user->setUrlImage($fileName);
            $entityManager->persist($user);
            $entityManager->flush();
            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                $user->getId(),
                $user->getAddEmail(),
                ['id' => $user->getId()]
            );

            $email = (new TemplatedEmail())
            ->from(new Address('rania.gasmi@esprit.tn', 'NoReply'))
            ->to($user->getAddEmail())
                ->subject('Verify Your Email Address')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context([
                    'user' => $user,
                    'signedUrl' => $signatureComponents->getSignedUrl(),
                    'expiresAtMessageKey' => 'expiresAtMessageKey', // Adjust this message key as needed

                ]);

            $mailer->send($email);
            $this->addFlash('success', 'Your account has been created. Please check your email to verify your account.');
            
          /*  $this->addFlash('success', 'Confirm your email at: '.$signatureComponents->getSignedUrl());*/

            // Generate a signed url and email it to the user
           /* $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                ->from(new Address('rania.gasmi@esprit.tn', 'NoReply'))
                    ->to($user->getAddEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );*/

            return $this->redirectToRoute('auth_oauth_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    
/*#[Route('/verify', name: 'app_verify_email')]
public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository,EntityManagerInterface $entityManager): Response
{
    $user = $userRepository->find($request->query->get('id'));
    if (!$user) {
        throw $this->createNotFoundException();
    }

    try {
        $verifyEmailHelper->validateEmailConfirmationFromRequest($request, $user->getId(), $user->getAddEmail());
    } catch (VerifyEmailExceptionInterface $e) {
        $this->addFlash('error', $e->getReason());
        return $this->redirectToRoute('app_register');
    }
    $user->setIsVerified(true);
    $entityManager->flush();
    return $this->redirectToRoute('app_login');


    
}*/


#[Route('/verify', name: 'app_verify_email')]
public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
{
    $user = $userRepository->find($request->query->get('id'));
    if (!$user) {
        throw $this->createNotFoundException();
    }

    try {
        // Validate the email confirmation
        $verifyEmailHelper->validateEmailConfirmationFromRequest($request, $user->getId(), $user->getAddEmail());

        // Mark the user's email as verified
        $user->setIsVerified(true);
        $entityManager->flush();

        $this->addFlash('success', 'Your email has been verified. You can now log in.');
        return $this->redirectToRoute('auth_oauth_login');
    } catch (VerifyEmailExceptionInterface $e) {
        $this->addFlash('error', $e->getReason());
        return $this->redirectToRoute('app_register');
    }
}



   /* #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }*/


   /* #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator,UserRepository $userRepository, EmailVerifier $emailVerifier ,EntityManagerInterface $entityManager ): Response
    {
       /* $id = $request->query->get('id');
        $token = $request->query->get('token');

        if (null === $id || null === $token) {
            throw new AccessDeniedException('Invalid verification link.');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            throw new AccessDeniedException('User not found.');
        }

        // Assuming handleEmailConfirmation returns a boolean indicating success
        if (!$user instanceof UserInterface || !$emailVerifier->handleEmailConfirmation($request, $user)) {
            throw new AccessDeniedException('Invalid verification link.');
        }

        // Optionally log in the user automatically
        // For example, you can use Symfony's Guard authenticator to log in the user
        return $this->redirectToRoute('app_login');*/
      /*  $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }*/
    
    
    
    

 ///////
 /*#[Route('/verification/{token}', name: 'app_verification')]
    public function verifyUser($token, JWTService $jwt , UserRepository $userRepository, EntityManagerInterface $em) : Response
    { 
        // verification of token 
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret')))
        {
            //nrecuperi l payload 
            $payload = $jwt->getPayload($token);

            // nrecuperi user of this token 
            $user = $userRepository->find($payload['user_id']);

            //verification of user existance 

            if($user && !$user->getIsVerified())
            {
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'user verifed ');
                return $this->redirectToRoute('app_profil');

            }

        }
        $this->addFlash('danger', 'token not valide or expired');
        return $this->redirectToRoute('app_login');
    }*/
    ///////


   /* #[Route('/resendverif' , name: 'app_resend')]
    public function resendVerif(JWTService $jwt ,SendMailService $mail, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if(!$user)
        {
            $this->addFlash('danger', 'you have to conenct first');
            return $this->redirectToRoute('app_login');
        }

        if($user->getIsVerified())
        {
            $this->addFlash('warning', 'this user already verified');
            return $this->redirectToRoute('app_profil');
        }

        // genreate jwt for user 
            // create header 

            $header = ['typ' =>'jwt', 'alg' =>'HS256'];

            //create payload 
            $payload = ['user_id' => $user->getId()];

            // genrate token 
            $token = $jwt->generate($header , $payload , $this->getParameter('app.jwtsecret'));

            

            // Send Mail
            $mail->send(
                'no-reply@monsite.net',
                $user->getAddEmail(),
                'Activation de votre compte sur le site CarthagoSmart',
                'register',
                compact('user' , 'token')
            );
            $this->addFlash('succes', 'Email send');
            return $this->redirectToRoute('app_login');
    }*/


}