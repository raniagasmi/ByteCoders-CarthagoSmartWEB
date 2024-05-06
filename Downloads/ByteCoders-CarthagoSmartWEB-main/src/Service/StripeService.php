<?php
namespace App\Service;

use Stripe\StripeClient; //client nestaamlouh bch nabaathou request l stripe api
use Symfony\Component\Env\Env;
class StripeService
{
    private $stripe;

    public function __construct(string $stripeApiKey)
    {
        $env = new Env();
        $stripeApiKey = $env->get('STRIPE_API_KEY');
        $this->stripe = new StripeClient($stripeApiKey);
    }

    public function createCharge(array $data)
    {
        return $this->stripe->charges->create($data);

    }

}
