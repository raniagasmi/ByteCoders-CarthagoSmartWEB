<?php

namespace App\Security;

use App\Security\AbstractOAuthAuthenticator;
use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class GoogleAuthenticator extends AbstractOAuthAuthenticator
{
    protected $serviceName='google';

    protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User
    {
        if (!($resourceOwner instanceof GoogleUser)){
            throw new \RuntimeException("we're expecting a google user");
        }
        if (false ==($resourceOwner->toArray()['email_verified']?? null) ){
            throw new AuthenticationException("your email is not verified");
        }

        return $repository->findOneBy([
            'google_id' => $resourceOwner->getId(),
            'addEmail' => $resourceOwner->getEmail()
        ]);


    }



}
