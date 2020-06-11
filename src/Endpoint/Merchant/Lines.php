<?php

namespace Paylike\Endpoint\Merchant;

use Paylike\Endpoint\Endpoint;
use Paylike\Utils\Cursor;

/**
 * Class Lines
 *
 * @package Paylike\Endpoint\Merchant
 */
class Lines extends Endpoint
{
    /**
     * @link https://github.com/paylike/api-docs#fetch-all-merchants
     *
     * @param $merchant_id
     * @param array $args
     * @return Cursor
     * @throws \Exception
     */
    public function find($merchant_id, $args = array())
    {
        $url = 'merchants/' . $merchant_id . '/lines';
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }
        $api_response = $this->paylike->client->request('GET', $url, $args);
        $lines = $api_response->json;
        return new Cursor($url, $args, $lines, $this->paylike);
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-all-lines-on-a-merchant
     *
     * @param $merchant_id
     * @param $line_id
     * @return Cursor
     * @throws \Exception
     */
    public function before($merchant_id, $line_id)
    {
        return $this->find($merchant_id, array('before' => $line_id));
    }

    /**
     * @link https://github.com/paylike/api-docs#fetch-all-lines-on-a-merchant
     *
     * @param $merchant_id
     * @param $line_id
     * @return Cursor
     * @throws \Exception
     */
    public function after($merchant_id, $line_id)
    {
        return $this->find($merchant_id, array('after' => $line_id));
    }
}
