<?php
namespace Paylike;
include_once( 'Adapter.php' );
include_once( 'Transaction.php' );

/**
 * Class Client
 * @package Paylike
 * Manages the app creation.
 */
class Client {


	/**
	 * @var
	 * This is the adapter, similar to a db engine,
	 * it can be changed with any class that has its capabilities,
	 * which are making requests to api. In the future the adapter
	 * will be extended from an interface.
	 */
	private static $adapter = null;


	/**
	 * @param $private_api_key
	 * Set the api key for future calls
	 */
	public static function setKey( $private_api_key ) {
		self::$adapter = new Adapter( $private_api_key );
	}


	/**
	 * @param null $private_api_key
	 * Returns the object that will be responsible for making the calls to the api
	 *
	 * @return bool|null|Adapter
	 */
	public static function getAdapter( $private_api_key = null ) {
		if ( self::$adapter ) {
			return self::$adapter;
		} else {
			if ( $private_api_key ) {
				return new Adapter( $private_api_key );
			} else {
				return false;
			}
		}
	}


}