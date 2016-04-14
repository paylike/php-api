<?php

namespace Paylike;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\HttpClient;
use Http\Client\Plugin\AuthenticationPlugin;
use Http\Client\Plugin\ErrorPlugin;
use Http\Client\Plugin\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\Authentication\BasicAuth;

class HttpClientFactory
{
    /**
     * Build the HTTP client.
     *
     * @param string     $apiKey
     * @param HttpClient $client Base HTTP client
     *
     * @return HttpClient
     */
    public static function create($apiKey, HttpClient $client = null)
    {
        if (!$client) {
            $client = HttpClientDiscovery::find();
        }

        $pluginClient = new PluginClient($client, [
            new ErrorPlugin(),
            new AuthenticationPlugin(
                $authentication = new BasicAuth('', $apiKey)
            ),
        ]);

        return new HttpMethodsClient(
            $pluginClient,
            MessageFactoryDiscovery::find()
        );
    }
}
