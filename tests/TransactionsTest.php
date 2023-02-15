<?php

namespace Paylike\Tests;

use Paylike\Exception\InvalidRequest;
use Paylike\Exception\NotFound;
use Paylike\Endpoint\Transactions;

class TransactionsTest extends BaseTest {
	/**
	 * @var Transactions
	 */
	protected $transactions;

	/**
	 *
	 */
	public function setUp(): void {
		parent::setUp();
		$this->transactions = $this->paylike->transactions();
	}

	/**
	 *
	 */
	public function testCreate() {
		$merchant_id = $this->merchant_id;
		$transaction_id = $this->transaction_id;

		$new_transaction_id = $this->transactions->create( $merchant_id, array(
			'transactionId' => $transaction_id,
			'currency'      => 'EUR',
			'amount'        => 200,
			'custom'        => array(
				'source' => 'php client test'
			)
		) );

		$this->assertNotEmpty( $new_transaction_id, 'primary key' );
		$this->assertIsString( $new_transaction_id, 'primary key type' );
	}

	/**
	 *
	 */
	public function testFetch() {
		$transaction_id = $this->transaction_id;

		$transaction = $this->transactions->fetch( $transaction_id );

		$this->assertEquals( $transaction_id, $transaction['id'], 'primary key' );
	}

	/**
	 *
	 */
	public function testFailFetch() {
		$this->expectException( NotFound::class );
		$this->transactions->fetch( 'wrong_id' );
	}

	/**
	 *
	 */
	public function testCapture() {
		$new_transaction_id = $this->createNewTransactionForTest();

		$transaction = $this->transactions->capture( $new_transaction_id, array(
			'currency' => 'EUR',
			'amount'   => 100
		) );

		$this->assertEquals( $transaction['capturedAmount'], 100,
			'captured amount' );
		$this->assertEquals( $transaction['pendingAmount'], 200,
			'pending amount' );

		$trail = $transaction['trail'];
		$this->assertCount( 1, $trail, 'length of trail' );
		$this->assertEquals(  true,$trail[0]['capture'], 'type of trail' );
		$this->assertEquals(  100, $trail[0]['amount'], 'amount in capture trail' );
	}

	/**
	 *
	 */
	public function testCaptureBiggerAmount() {
		$this->expectException( InvalidRequest::class );

		$new_transaction_id = $this->createNewTransactionForTest();
		$this->transactions->capture( $new_transaction_id, array(
			'currency' => 'EUR',
			'amount'   => 400
		) );
	}

	/**
	 *
	 */
	public function testRefund() {
		$new_transaction_id = $this->createNewTransactionForTest();

		$this->transactions->capture( $new_transaction_id, array(
			'currency' => 'EUR',
			'amount'   => 200
		) );

		$transaction = $this->transactions->refund( $new_transaction_id, array(
			'amount' => 120
		) );

		$this->assertEquals( 200, $transaction['capturedAmount'],
			'captured amount' );
		$this->assertEquals(  100,$transaction['pendingAmount'],
			'pending amount' );
		$this->assertEquals(  120,$transaction['refundedAmount'],
			'refunded amount' );

		$trail = $transaction['trail'];
		$this->assertCount( 2, $trail, 'length of trail' );
		$this->assertEquals(  true,$trail[0]['capture'], 'type of trail' );
		$this->assertEquals(  200,$trail[0]['amount'], 'amount in capture trail' );
		$this->assertEquals(  true,$trail[1]['refund'], 'type of trail' );
		$this->assertEquals(  120,$trail[1]['amount'], 'amount in refund trail' );
	}

	/**
	 *
	 */
	public function testVoid() {
		$new_transaction_id = $this->createNewTransactionForTest();

		$transaction = $this->transactions->void( $new_transaction_id, array(
			'amount' => 200
		) );

		$this->assertEquals(  200,$transaction['voidedAmount'], 'voided amount' );
		$this->assertEquals(  100,$transaction['pendingAmount'],
			'pending amount' );

		$trail = $transaction['trail'];
		$this->assertCount( 1, $trail, 'length of trail' );
		$this->assertEquals(  true,$trail[0]['void'], 'type of trail' );
		$this->assertEquals(  200,$trail[0]['amount'], 'amount in void trail' );
	}

	/**
	 * @return bool|mixed
	 */
	private function createNewTransactionForTest() {
		$merchant_id = $this->merchant_id;
		$transaction_id = $this->transaction_id;

		$new_transaction_id = $this->transactions->create( $merchant_id, array(
			'transactionId' => $transaction_id,
			'currency'      => 'EUR',
			'amount'        => 300,
			'custom'        => array(
				'source' => 'php client test'
			)
		) );

		return $new_transaction_id;
	}

	/**
	 * @throws \Exception
	 */
	public function testGetAllTransactionsCursor() {
		$merchant_id = $this->merchant_id;
		$api_transactions = $this->transactions->find( $merchant_id );
		$ids = array();
		foreach ( $api_transactions as $transaction ) {
			// the transaction array grows as needed
			$ids[] = $transaction['id'];
		}

		$this->assertGreaterThan( 0, count( $ids ), 'number of transactions' );
	}


	/**
	 * @throws \Exception
	 */
	public function testGetAllTransactionsCursorOptions() {
		$merchant_id = $this->merchant_id;
		$limit = 10;
		$after = '63ecabe99b99b157051e9c31';
		$before = '63ecabeec9586702e2ebd26d';
		$api_transactions = $this->transactions->find( $merchant_id, array(
			'limit'  => $limit,
			'after'  => $after,
			'before' => $before
		) );

		$this->assertGreaterThan( 0, count( $api_transactions ), 'number of transactions' );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetAllTransactionsCursorBefore() {
		$merchant_id = $this->merchant_id;
		$before = '63ecabeec9586702e2ebd26d';
		$api_transactions = $this->transactions->before( $merchant_id, $before );

		$this->assertGreaterThan( 0, count( $api_transactions ), 'number of transactions' );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetAllTransactionsCursorAfter() {
		$merchant_id = $this->merchant_id;
		$after = '63ecabe99b99b157051e9c31';
		$api_transactions = $this->transactions->before( $merchant_id, $after );


		$this->assertGreaterThan( 0, count( $api_transactions ), 'number of transactions' );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetAllTransactionsFilter() {
		$merchant_id = $this->merchant_id;
		$api_transactions = $this->transactions->find( $merchant_id, array(
			'filter' => array(
				'test' => true
			),
		) );

		$this->assertGreaterThan( 0, count( $api_transactions ), 'number of transactions' );
	}
}
