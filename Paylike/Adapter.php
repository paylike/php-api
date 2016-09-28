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

	public $api_url = 'https://api.paylike.io';
	private $api_key;

	/**
	 * Adapter constructor.
	 *
	 * @param $private_api_key
	 */
	public function __construct( $private_api_key ) {
		$this->setApiKey( $private_api_key );
	}


	/**
	 * @param $key
	 * set the api key.
	 */
	public function setApiKey( $key ) {
		$this->api_key = $key;
	}

	/**
	 * @param $url this is required, do not use the full url,
	 * only prepend the params eg: transactions/' . $transaction_id . '/captures'
	 * @param $data this is optional
	 * Actual call to the api via curl.
	 *
	 * @return bool|mixed
	 */
	public function request( $url, $data = null ) {
		$url = $this->api_url . '/' . $url;
		$ch  = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_USERPWD, ":" . $this->api_key );
		if ( $data ) {
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result   = curl_exec( $ch );
		$httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );
		$output = json_decode( $result, true );
		if ( $httpcode >= 200 || $httpcode <= 299 ) {
			return $output;
		} else {
			return false;
		}
	}


}