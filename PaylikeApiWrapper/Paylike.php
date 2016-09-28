<?php
namespace PaylikeApps;
include_once( 'PaylikeAdapter.php' );

/**
 * Class Paylike
 * @package PaylikeApps
 * This is the interface class, that allows operations to take place, abstracting the call logic.
 */
class Paylike {


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
		self::$adapter = new PaylikeAdapter( $private_api_key );
	}



	/**
	 * @param $transaction_id
	 *
	 * @return int|mixed
	 * Return the transaction object to check the status
	 *
	 */
	public static function fetchTransaction( $transaction_id ) {
		$adapter=self::getAdapter();
		if(!$adapter)
		{
			return -1;
		}
		return $adapter->request('transactions/' . $transaction_id);

	}


	/**
	 * @param $transaction_id
	 * The authorization takes place via the client script,
	 * so this actually returns the transaction object which needs to be validated.
	 *
	 * @return int|mixed
	 */
	public static function authorize( $transaction_id ) {
		return self::fetchTransaction($transaction_id);
	}


	/**
	 * @param $transaction_id
	 * @param $amount
	 * @param $currency
	 * @param string $description
	 * Capture a transaction that has been authorized. This also returns the transaction object which needs to be validated
	 * @return bool|int|mixed
	 */
	public static function capture($transaction_id,$amount,$currency,$description=''){

		$adapter=self::getAdapter();
		if(!$adapter)
		{
			return -1;
		}
		$data = array(
			'amount'   => $amount,
			'currency' => $currency,
			'descriptor'=>$description
		);

		return $adapter->request('transactions/' . $transaction_id . '/captures',$data);


	}


	/**
	 * @param $transaction_id
	 * @param $amount
	 * You can void a certain amount of a transaction that has been authorized but not captured.
	 *
	 * @return bool|int|mixed
	 */
	public static function void($transaction_id,$amount)
	{
		$adapter=self::getAdapter();
		if(!$adapter)
		{
			return -1;
		}
		$data = array(
			'amount'   => $amount,
		);

		return $adapter->request('transactions/' . $transaction_id . '/voids',$data);
	}

	/**
	 * @param $transaction_id
	 * @param $amount
	 * You can return a certain amount of a transaction that has been captured.
	 *
	 * @return bool|int|mixed
	 */
	public static function refund($transaction_id,$amount,$description='')
	{
		$adapter=self::getAdapter();
		if(!$adapter)
		{
			return -1;
		}
		$data = array(
			'amount'   => $amount,
			'descriptor'=>$description
		);

		return $adapter->request('transactions/' . $transaction_id . '/refunds',$data);
	}



	/**
	 * @param null $private_api_key
	 * Returns the object that will be responsible for making the calls to the api
	 * @return bool|null|PaylikeAdapter
	 */
	private static function getAdapter( $private_api_key = null ) {
		if ( self::$adapter ) {
			return self::$adapter;
		} else {
			if ( $private_api_key ) {
				return new PaylikeAdapter( $private_api_key );
			} else {
				return false;
			}
		}
	}


}