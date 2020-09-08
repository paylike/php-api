<?php

namespace Paylike\Endpoint\Merchant;

use Paylike\Endpoint\Endpoint;
use Paylike\Utils\Cursor;

/**
 * Class Apps
 *
 * @package Paylike\Endpoint\Merchant
 */
class Apps extends Endpoint
{

    /**
     * @link https://github.com/paylike/api-docs#fetch-all-apps-on-a-merchant
     *
     * @param $merchant_id
     * @param array $args
     * @return Cursor
     * @throws \Exception
     */
    public function find($merchant_id, $args = array())
    {
        $url = 'merchants/' . $merchant_id . '/apps';
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }
        $api_response = $this->paylike->client->request('GET', $url, $args);
        $apps = $api_response->json;
        return new Cursor($url, $args, $apps, $this->paylike);
    }

    /**
     * @link https://github.com/paylike/api-docs#add-app-to-a-merchant
     *
     * @param $args array
     *
     * @return string
     */
    public function add($merchant_id, $app_id)
    {
        $url = 'merchants/' . $merchant_id . '/apps';

        $args = array(
            'appId' => $app_id
        );

        $api_response = $this->paylike->client->request('POST', $url, $args);

        return $api_response;
    }

    /**
     * @link https://github.com/paylike/api-docs#revoke-app-from-a-merchant
     *
     * @param $args array
     *
     * @return string
     */
    public function revoke($merchant_id, $app_id)
    {
        $url = 'merchants/' . $merchant_id . '/apps/'.$app_id;


        $api_response = $this->paylike->client->request('DELETE', $url);

        return $api_response;
    }

}
