<?php

namespace Paylike\Tests;

use Paylike\Endpoint\Merchant\Apps;
use Paylike\Paylike;

class MerchantsAppsTest extends BaseTest
{
    /**
     * @var Apps
     */
    protected $apps;

    /**
     *
     */
    public function setUp():void
    {
        parent::setUp();
        $this->apps = $this->paylike->merchants()->apps();
    }


    /**
     * @throws \Exception
     */
    public function testGetAllAppsCursor()
    {
        $merchant_id = $this->merchant_id;
        $apps = $this->apps->find($merchant_id);
        $ids = array();
        foreach ($apps as $app) {
            // the apps array grows as needed
            $ids[] = $app['id'];
        }

        $this->assertGreaterThan(0, count($ids), 'number of apps');
    }

    public function testAdd()
    {
        $merchant_id = $this->merchant_id;
        $app_id = '5f5637ab4691ba779dc2b9b3';
        $response = $this->apps->add($merchant_id, $app_id);

        $this->assertEquals(201, $response->code);
    }

    public function testRevoke()
    {
        $merchant_id = $this->merchant_id;
        $app_id = '5f5637ab4691ba779dc2b9b3';
        $response = $this->apps->revoke($merchant_id, $app_id);

        $this->assertEquals(204, $response->code);
    }

}
