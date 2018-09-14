<?php

namespace Paylike;

use Paylike\HttpClient\HttpClientInterface;
use Paylike\HttpClient\CurlClient;
use Paylike\Resource\Apps;
use Paylike\Resource\Merchants;
use Paylike\Resource\Transactions;
use Paylike\Resource\Cards;

/**
 * Class Paylike
 *
 * @package Paylike
 */
class Paylike
{
    /**
     * @var string
     */
    const BASE_URL = 'https://api.paylike.io';

    /**
     * @var HttpClientInterface
     */
    public $client;

    /**
     * @var string
     */
    private $api_key;


    /**
     * Paylike constructor.
     *
     * @param                          $api_key
     * @param HttpClientInterface $client
     * @throws Exception\ApiException
     */
    public function __construct($api_key, HttpClientInterface $client = null)
    {
        $this->api_key = $api_key;
        $this->client  = $client ? $client
            : new CurlClient($this->api_key, self::BASE_URL);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }


    /**
     * @return Apps
     */
    public function apps()
    {
        return new Apps($this);
    }

    /**
     * @return Merchants
     */
    public function merchants()
    {
        return new Merchants($this);
    }

    /**
     * @return Transactions
     */
    public function transactions()
    {
        return new Transactions($this);
    }

    /**
     * @return Cards
     */
    public function cards()
    {
        return new Cards($this);
    }
}
