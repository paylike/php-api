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
	 * @param $transaction_id
	 *
	 * @return int|mixed
	 * Return the transaction data
	 *
	 */
	public static function fetch( $transaction_id ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}

		return $adapter->request( 'transactions/' . $transaction_id );

	}


	/**
	 * @param $transaction_id
	 * The authorization takes place via the client script,
	 * so this actually returns the transaction data
	 *
	 * @return int|mixed
	 */
	public static function authorize( $transaction_id ) {
		return self::fetch( $transaction_id );
	}


	/**
	 * @param $transaction_id
	 * @param $amount
	 * @param $currency
	 * @param string $description
	 * Capture a transaction that has been authorized.
	 * This also returns the transaction data.
	 *
	 * @return bool|int|mixed
	 */
	public static function capture( $transaction_id, $amount, $currency, $description = '' ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}
		$data = array(
			'amount'     => $amount,
			'currency'   => $currency,
			'descriptor' => $description
		);

		return $adapter->request( 'transactions/' . $transaction_id . '/captures', $data );


	}


	/**
	 * @param $transaction_id
	 * @param $amount
	 * You can void a certain amount of a transaction that
	 * has been authorized but not captured.
	 *
	 * @return bool|int|mixed
	 */
	public static function void( $transaction_id, $amount ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}
		$data = array(
			'amount' => $amount,
		);

		return $adapter->request( 'transactions/' . $transaction_id . '/voids', $data );
	}

	/**
	 * @param $transaction_id
	 * @param $amount
	 * You can return a certain amount of a transaction
	 * that has been captured.
	 *
	 * @return bool|int|mixed
	 */
	public static function refund( $transaction_id, $amount, $description = '' ) {
		$adapter = Client::getAdapter();
		if ( ! $adapter ) {
			return - 1;
		}
		$data = array(
			'amount'     => $amount,
			'descriptor' => $description
		);

		return $adapter->request( 'transactions/' . $transaction_id . '/refunds', $data );
	}
}