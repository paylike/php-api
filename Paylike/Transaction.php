<?php
namespace Paylike;
/**
 * Class Transaction
 * @package Paylike
 * Handles transaction operations.
 *
 * @version    1.0.0
 */
class Transaction {

	/**
	 * @param $transactionId
	 *
	 * @return int|mixed
	 * Return the transaction data
	 *
	 */
	public static function fetch( $transactionId ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}

		return $adapter->request( 'transactions/' . $transactionId );
	}
    

	/**
	 * @param $transactionId
	 * Capture a transaction that has been authorized.
	 * This also returns the transaction data.
	 *
	 * @param $data
	 *
	 * @return bool|int|mixed
	 */
	public static function capture( $transactionId, $data ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}

		return $adapter->request( 'transactions/' . $transactionId . '/captures', $data );
	}

	/**
	 * @param $transactionId
	 * You can void a certain amount of a transaction that
	 * has been authorized but not captured.
	 *
	 * @param $data
	 *
	 * @return bool|int|mixed
	 */
	public static function void( $transactionId, $data ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}

		return $adapter->request( 'transactions/' . $transactionId . '/voids', $data );
	}

	/**
	 * @param $transactionId
	 * You can return a certain amount of a transaction
	 * that has been captured.
	 *
	 * @param $data
	 *
	 * @return bool|int|mixed
	 */
	public static function refund( $transactionId, $data ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}

		return $adapter->request( 'transactions/' . $transactionId . '/refunds', $data );
	}



}