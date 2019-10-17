<?php

namespace Paylike\Endpoint;

/**
 * Class Apps
 *
 * @package Paylike\Endpoint
 */
class Apps extends Endpoint
{
    /**
     * @link https://github.com/paylike/api-docs#create-an-app
     *
     * @param $args array
     *
     * @return string
     */
    public function create($args)
    {
        $url = 'apps';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['app'];
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-current-app
     * @return array
     */
    public function fetch()
    {
        $url = 'me';

        $api_response = $this->paylike->client->request('GET', $url);

        return $api_response->json['identity'];
    }

}
