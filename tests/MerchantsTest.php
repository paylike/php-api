<?php

namespace Paylike\Tests;

use Paylike\Resource\Merchants;

class MerchantsTest extends BaseTest
{
    /**
     * @var Merchants
     */
    protected $merchants;

    public function setUp()
    {
        parent::setUp();
        $this->merchants = $this->paylike->merchants();
    }


    public function testCreate()
    {
        $merchant_id = $this->merchants->create(array(
            'company'    => array(
                'country' => 'DK'
            ),
            'currency'   => 'DKK',
            'email'      => 'john@example.com',
            'website'    => 'https://example.com',
            'descriptor' => 'Test Merchant Name',
            'test'       => true,
        ));

        $this->assertNotEmpty($merchant_id, 'primary key');
        $this->assertInternalType('string', $merchant_id, 'primary key type');
    }

    public function testFetch()
    {
        $merchant_id = $this->merchant_id;

        $merchant = $this->merchants->fetch($merchant_id);

        $this->assertEquals($merchant['id'], $merchant_id, 'primary key');
    }

    public function testUpdate()
    {
        $merchant_id = $this->merchant_id;

        $this->merchants->update($merchant_id, array(
            'name' => 'Updated Merchant Name'
        ));
    }
}
