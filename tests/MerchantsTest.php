<?php

namespace Paylike\Tests;

use Paylike\Endpoint\Merchants;

class MerchantsTest extends BaseTest
{
    /**
     * @var Merchants
     */
    protected $merchants;

    /**
     *
     */
    public function setUp():void
    {
        parent::setUp();
        $this->merchants = $this->paylike->merchants();
    }


    /**
     *
     */
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
        $this->assertIsString( $merchant_id, 'primary key type');
    }

    /**
     *
     */
    public function testFetch()
    {
        $merchant_id = $this->merchant_id;

        $merchant = $this->merchants->fetch($merchant_id);

        $this->assertEquals($merchant['id'], $merchant_id, 'primary key');
    }

    /**
     *
     */
    public function testUpdate()
    {
        $merchant_id = $this->merchant_id;

        $response = $this->merchants->update($merchant_id, array(
            'name' => 'Updated Merchant Name'
        ));

		$this->assertNotEmpty($response, 'response');

    }

    /**
     * @throws \Exception
     */
    public function testGetAllMerchantsCursor()
    {
        $app_id = $this->app_id;
        $api_merchants = $this->merchants->find($app_id);
        $ids = array();
        foreach ($api_merchants as $merchant) {
            // the merchants array grows as needed
            $ids[] = $merchant['id'];
        }

        $this->assertGreaterThan(0, count($ids), 'number of merchants');
    }


    /**
     * @throws \Exception
     */
    public function testGetAllMerchantsCursorOptions()
    {
        $app_id = $this->app_id;
        $after = '601267ebf700a44f17ee4fbf';
        $before = '63ea11e29b99b157051e4455';
        $api_merchants = $this->merchants->find($app_id, array(
            'after' => $after,
            'before' => $before
        ));
        $ids = array();
        foreach ($api_merchants as $merchant) {
            // the merchants array grows as needed
            $ids[] = $merchant['id'];
        }

        $this->assertGreaterThan(0, count($api_merchants), 'number of merchants');
    }

    /**
     * @throws \Exception
     */
    public function testGetAllMerchantsCursorBefore()
    {
        $app_id = $this->app_id;
        $before = '63ea11e29b99b157051e4455';
        $api_merchants = $this->merchants->before($app_id, $before);
        $ids = array();
        foreach ($api_merchants as $merchant) {
            // the merchants array grows as needed
            $ids[] = $merchant['id'];
        }

        $this->assertGreaterThan(0, count($api_merchants), 'number of merchants');
    }

    /**
     * @throws \Exception
     */
    public function testGetAllMerchantsCursorAfter()
    {
        $app_id = $this->app_id;
        $after = '5952889e764d2754c974fe94';
        $api_merchants = $this->merchants->after($app_id, $after);
        $ids = array();
        foreach ($api_merchants as $merchant) {
            // the merchants array grows as needed
            $ids[] = $merchant['id'];
        }

        $this->assertGreaterThan(0, count($api_merchants), 'number of merchants');
    }
}
