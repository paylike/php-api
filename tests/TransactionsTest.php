<?php

namespace Paylike\Tests;

use Paylike\Exception\InvalidRequest;
use Paylike\Exception\NotFound;
use Paylike\Resource\Transactions;

class TransactionsTest extends BaseTest
{
    /**
     * @var Transactions
     */
    protected $transactions;

    public function setUp()
    {
        parent::setUp();
        $this->transactions = $this->paylike->transactions();
    }

    public function testCreate()
    {
        $merchant_id    = $this->merchant_id;
        $transaction_id = $this->transaction_id;

        $new_transaction_id = $this->transactions->create($merchant_id, array(
            'transactionId' => $transaction_id,
            'currency'      => 'EUR',
            'amount'        => 200,
            'custom'        => array(
                'source' => 'php client test'
            )
        ));

        $this->assertNotEmpty($new_transaction_id, 'primary key');
        $this->assertInternalType('string', $new_transaction_id, 'primary key type');
    }

    public function testFetch()
    {
        $transaction_id = $this->transaction_id;

        $transaction = $this->transactions->fetch($transaction_id);

        $this->assertEquals($transaction['id'], $transaction_id, 'primary key');
    }

    public function testFailFetch()
    {
        $this->setExpectedException(NotFound::class);
        $this->transactions->fetch('wrong id');
    }

    public function testCapture()
    {
        $new_transaction_id = $this->createNewTransactionForTest();

        $transaction = $this->transactions->capture($new_transaction_id, array(
            'currency' => 'EUR',
            'amount'   => 100
        ));

        $this->assertEquals($transaction['capturedAmount'], 100,
            'captured amount');
        $this->assertEquals($transaction['pendingAmount'], 200,
            'pending amount');

        $trail = $transaction['trail'];
        $this->assertCount(1, $trail, 'length of trail');
        $this->assertEquals($trail[0]['capture'], true, 'type of trail');
        $this->assertEquals($trail[0]['amount'], 100, 'amount in capture trail');
    }

    public function testCaptureBiggerAmount()
    {
        $this->setExpectedException(InvalidRequest::class);

        $new_transaction_id = $this->createNewTransactionForTest();
        $this->transactions->capture($new_transaction_id, array(
            'currency' => 'EUR',
            'amount'   => 400
        ));
    }

    public function testRefund()
    {
        $new_transaction_id = $this->createNewTransactionForTest();

        $this->transactions->capture($new_transaction_id, array(
            'currency' => 'EUR',
            'amount'   => 200
        ));

        $transaction = $this->transactions->refund($new_transaction_id, array(
            'amount' => 120
        ));

        $this->assertEquals($transaction['capturedAmount'], 200,
            'captured amount');
        $this->assertEquals($transaction['pendingAmount'], 100,
            'pending amount');
        $this->assertEquals($transaction['refundedAmount'], 120,
            'refunded amount');

        $trail = $transaction['trail'];
        $this->assertCount(2, $trail, 'length of trail');
        $this->assertEquals($trail[0]['capture'], true, 'type of trail');
        $this->assertEquals($trail[0]['amount'], 200, 'amount in capture trail');
        $this->assertEquals($trail[1]['refund'], true, 'type of trail');
        $this->assertEquals($trail[1]['amount'], 120, 'amount in refund trail');
    }

    public function testVoid()
    {
        $new_transaction_id = $this->createNewTransactionForTest();

        $transaction = $this->transactions->void($new_transaction_id, array(
            'amount' => 200
        ));

        $this->assertEquals($transaction['voidedAmount'], 200, 'voided amount');
        $this->assertEquals($transaction['pendingAmount'], 100,
            'pending amount');

        $trail = $transaction['trail'];
        $this->assertCount(1, $trail, 'length of trail');
        $this->assertEquals($trail[0]['void'], true, 'type of trail');
        $this->assertEquals($trail[0]['amount'], 200, 'amount in void trail');
    }

    /**
     * @return bool|mixed
     */
    private function createNewTransactionForTest()
    {
        $merchant_id    = $this->merchant_id;
        $transaction_id = $this->transaction_id;

        $new_transaction_id = $this->transactions->create($merchant_id, array(
            'transactionId' => $transaction_id,
            'currency'      => 'EUR',
            'amount'        => 300,
            'custom'        => array(
                'source' => 'php client test'
            )
        ));

        return $new_transaction_id;
    }
}
