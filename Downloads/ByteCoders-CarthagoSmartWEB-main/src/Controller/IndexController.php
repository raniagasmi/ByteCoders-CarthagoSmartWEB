<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $username = $this->getUser()->getUserIdentifier();
        // Configuration for JWT token
        $randomKey = random_bytes(32);

        $config = Configuration::forSymmetricSigner(
            new Sha256(),  // Using HMAC SHA-256 signer
            $key = InMemory::plainText($randomKey)
        );

        // Get the current time
        $now = new \DateTimeImmutable();

        // Build the JWT token
        $token = $config->builder()
            ->issuedBy('http://example.com')
            ->permittedFor('http://example.org')
            ->identifiedBy('4f1g23a12aa', true)
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', 1)
            ->getToken($config->signer(), $config->signingKey());

        // Get the token string
        $tokenString = $token->toString();

        // Set the token as a cookie
        $response =  $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);

        $response->headers->setCookie(
            new Cookie(
                'mercureAuthorization',
                $tokenString,
                (new \DateTime())->add(new \DateInterval('PT2H')),
                '/.well-known/mercure',
                null,
                false,
                true,
                false,
                'strict'
            )
        );

        return $response;
    }
}
