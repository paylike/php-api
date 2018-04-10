<?php

namespace Paylike\Resource;

/**
 * Class Transactions
 *
 * @package Paylike\Resource
 */
class Transactions extends Resource
{
    /**
     * @link https://github.com/paylike/api-docs#create-a-transaction
     *
     * @param $merchant_id
     * @param $args array
     *
     * @return string
     */
    public function create($merchant_id, $args)
    {
        $url = 'merchants/' . $merchant_id . '/transactions';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['transaction']['id'];
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-a-transaction
     *
     * @param $transaction_id
     *
     * @return array
     */
    public function fetch($transaction_id)
    {
        $url = 'transactions/' . $transaction_id;

        $api_response = $this->paylike->client->request('GET', $url);

        return $api_response->json['transaction'];
    }

    /**
     * @link https://github.com/paylike/api-docs#capture-a-transaction
     *
     * @param $transaction_id
     * @param $args array
     *
     * @return array
     */
    public function capture($transaction_id, $args)
    {
        $url = 'transactions/' . $transaction_id . '/captures';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['transaction'];
    }

    /**
     * @link https://github.com/paylike/api-docs#void-a-transaction
     *
     * @param $transaction_id
     * @param $args array
     *
     * @return array
     */
    public function void($transaction_id, $args)
    {
        $url = 'transactions/' . $transaction_id . '/voids';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['transaction'];
    }

    /**
     * @link https://github.com/paylike/api-docs#refund-a-transaction
     *
     * @param $transaction_id
     * @param $args array
     *
     * @return array
     */
    public function refund($transaction_id, $args)
    {
        $url = 'transactions/' . $transaction_id . '/refunds';

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response->json['transaction'];
    }
}
