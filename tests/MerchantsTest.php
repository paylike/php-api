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
            'company' => array(
                'country' => 'DK'
            ),
            'currency' => 'DKK',
            'email' => 'john@example.com',
            'website' => 'https://example.com',
            'descriptor' => 'Test Merchant Name',
            'test' => true,
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

    public function testGetAll()
    {
        $app_id = $this->app_id;
        $merchants = array();
        $limit = 10;
        $before = null;

        do {
            $api_merchants = $this->merchants->get($app_id, $limit, $before);
            if (count($api_merchants) < $limit) {
                $before = null;
            } else {
                $before = $api_merchants[$limit - 1]['id'];
            }
            $merchants = array_merge($merchants,$api_merchants);
        } while ($before);

        $this->assertGreaterThan(0, count($merchants), 'number of merchants');
    }

    public function testUpdate()
    {
        $merchant_id = $this->merchant_id;

        $this->merchants->update($merchant_id, array(
            'name' => 'Updated Merchant Name'
        ));
    }
}
