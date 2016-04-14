<?php

namespace Paylike;

use Http\Client\HttpClient;
use Paylike\Api\App;
use Paylike\Api\Card;
use Paylike\Api\Merchant;
use Paylike\Api\Transaction;
use Paylike\Api\User;

class Paylike
{
    const BASE_URL = 'https://api.paylike.io';

    protected $client;

    /**
     * Constructor.
     *
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve the Transation API.
     *
     * @return Transaction
     */
    public function transaction()
    {
        return new Transaction($this->client);
    }

    /**
     * Retrieve the App API.
     *
     * @return App
     */
    public function app()
    {
        return new App($this->client);
    }

    /**
     * Retrieve the Merchant API.
     *
     * @return Merchant
     */
    public function merchant()
    {
        return new Merchant($this->client);
    }

    /**
     * Retrieve the Card API.
     *
     * @return Card
     */
    public function card()
    {
        return new Card($this->client);
    }

    /**
     * Retrieve the User API.
     *
     * @return User
     */
    public function user()
    {
        return new User($this->client);
    }
}
