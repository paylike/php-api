<?php

namespace Paylike\Resource;

/**
 * Class Merchants
 *
 * @package Paylike\Resource
 */
class Merchants extends Resource
{
    /**
     * @link https://github.com/paylike/api-docs#create-a-merchant
     *
     * @param $args array
     *
     * @return string
     */
    public function create($args)
    {
        $url = 'merchants';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['merchant']['id'];
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-a-merchant
     *
     * @param $merchant_id
     *
     * @return mixed
     */
    public function fetch($merchant_id)
    {
        $url = 'merchants/' . $merchant_id;

        $api_response = $this->paylike->client->request('GET', $url);

        return $api_response->json['merchant'];
    }

    /**
     * https://github.com/paylike/api-docs#update-a-merchant
     * @param $merchant_id
     * @param $args
     *
     * @return void
     */
    public function update($merchant_id, $args)
    {
        $url = 'merchants/' . $merchant_id;

        $this->paylike->client->request('PUT', $url, $args);
    }
}
