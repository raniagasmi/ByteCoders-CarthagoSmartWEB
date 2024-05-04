<?php


namespace App\Security;

use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;


abstract class AbstractOAuthAuthenticator extends OAuth2Authenticator
{

    use TargetPathTrait;
    protected $serviceName = '';
    private $router;


    private $clientRegistry;
    private $repository;
    private $registrationService;

    public function __construct (ClientRegistry $clientRegistry, RouterInterface $router, UserRepository $repository, OAuthRegistrationService $registrationService){
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
        $this->repository=$repository;
        $this->registrationService=$registrationService;

    }

    public function supports(Request $request): ?bool{
        return 'auth_oauth_check' == $request->attributes->get('_route') &&
        $request->get('service')==$this->serviceName;
    }
  //l'authentification est supportée

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
  {
      $targetPath = $this->getTargetPath($request->getSession(),$firewallName);
      if ($targetPath){
        return new RedirectResponse($targetPath);

      }
      return new RedirectResponse($this->router->generate('index'));

  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
  {
      
    if ($request->hasSession()){

        $request->getSession()->set('_security.last_error',$exception);
    }
      return new RedirectResponse($this->router->generate('auth_oauth_login'));
  }

 
  /*public function authenticate(Request $request): SelfValidatingPassport
  {
      $credentials = $this->fetchAccessToken($this->getClient());
      $resourceOwner = $this->getResourceOwnerFromCredentials($credentials);
      $user = $this->getUserFromResourceOwner($resourceOwner, $this->repository);
     
      if (null == $user){
        $user = $this->registrationService->persist($resourceOwner, $this->repository);
    }
  
      return new SelfValidatingPassport(
          new UserBadge($user->getAddEmail(), function () use ($user) {
              return $user;
          }),
          [
              new RememberMeBadge()
          ]
      );
  }*/

  public function authenticate(Request $request): SelfValidatingPassport
{
    $credentials = $this->fetchAccessToken($this->getClient());
    $resourceOwner = $this->getResourceOwnerFromCredentials($credentials);
    $user = $this->getUserFromResourceOwner($resourceOwner, $this->repository);
   
   if ($user === null){
        // Pass only $resourceOwner to persist method
     $user = $this->registrationService->persist($resourceOwner);
    }

    return new SelfValidatingPassport(
        new UserBadge($user->getAddEmail(), function () use ($user) {
            return $user;
        }),
        [
            new RememberMeBadge()
        ]
    );
}


  private function getClient(): OAuth2ClientInterface
  {
    return $this->clientRegistry->getClient($this->serviceName);

  }

  
  protected function getResourceOwnerFromCredentials(AccessToken $credentials): ResourceOwnerInterface
{
    return $this->getClient()->fetchUserFromToken($credentials);
}



    abstract protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User;


}
