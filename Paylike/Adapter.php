<?php
namespace Paylike;
/**
 * Class Adapter
 * @package Paylike
 * The adapter class taking care of the calls to the api.
 *
 * The purpose of this is to abstract the requests
 * so that this can be changed depending on the environment.
 *
 * @version    1.0.0
 */
class Adapter {

    public $apiUrl = 'https://api.paylike.io';
    private $apiKey;

    /**
     * Adapter constructor.
     *
     * @param $privateApiKey
     */
    public function __construct( $privateApiKey ) {
        if ( $privateApiKey ) {
            $this->setApiKey( $privateApiKey );
        } else {
            trigger_error('Private Key is missing!',E_USER_ERROR);
            return null;
        }
    }

    /**
     * @param $key
     * set the api key.
     */
    public function setApiKey( $key ) {
        $this->apiKey = $key;
    }

    /**
     * @param $url this is required, do not use the full url,
     * only prepend the params eg: transactions/' . $transactionId . '/captures'
     * @param $data this is optional
     * Actual call to the api via curl.
     *
     * @return bool|mixed
     */
    public function request( $url, $data = null ) {
        $url = $this->apiUrl . '/' . $url;
        $ch  = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_USERPWD, ":" . $this->apiKey );
        if ( $data ) {
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        }
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result   = curl_exec( $ch );
        $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        $output = json_decode( $result, true );
        if ( $httpCode >= 200 || $httpCode <= 299 ) {
            return $output;
        } else {
            return false;
        }
    }


}