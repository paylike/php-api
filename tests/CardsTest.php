<?php

namespace Paylike\Tests;

use Paylike\Exception\NotFound;
use Paylike\Endpoint\Cards;

class CardsTest extends BaseTest
{
    /**
     * @var Cards
     */
    protected $cards;

    public function setUp():void
    {
        parent::setUp();
        $this->cards = $this->paylike->cards();
    }


    public function testCreate()
    {
        $transaction_id = $this->transaction_id;
        $merchant_id    = $this->merchant_id;

        $card_id = $this->cards->create($merchant_id, array(
            'transactionId' => $transaction_id
        ));

        $this->assertNotEmpty($card_id, 'primary key');
        $this->assertIsString($card_id, 'primary key type');
    }

    public function testFetch()
    {
        $transaction_id = $this->transaction_id;
        $merchant_id    = $this->merchant_id;

        $card_id = $this->cards->create($merchant_id, array(
            'transactionId' => $transaction_id
        ));

        $card = $this->cards->fetch($card_id);

        $this->assertEquals($card['id'], $card_id, 'primary key');
    }

    public function testFailFetch()
    {
        $this->expectException(NotFound::class);
        $this->cards->fetch('wrong_id');
    }
}
