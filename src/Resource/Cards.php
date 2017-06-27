<?php

namespace Paylike\Resource;

/**
 * Class Cards
 *
 * @package Paylike\Resource
 */
class Cards extends Resource
{
    /**
     * @link https://github.com/paylike/api-docs#save-a-card
     *
     * @param $merchant_id
     * @param $args array
     *
     * @return string
     */
    public function create($merchant_id, $args)
    {
        $url = 'merchants/' . $merchant_id . '/cards';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['card']['id'];
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-a-card
     *
     * @param $card_id
     *
     * @return array
     */
    public function fetch($card_id)
    {
        $url = 'cards/' . $card_id;

        $api_response = $this->paylike->client->request('GET', $url);

        return $api_response->json['card'];
    }
}
