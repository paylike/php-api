<?php

namespace Paylike\Tests;

use Paylike\Endpoint\Apps;

class AppsTest extends BaseTest
{
    /**
     * @var Apps
     */
    protected $apps;

    public function setUp():void
    {
        parent::setUp();
        $this->apps = $this->paylike->apps();
    }


    public function testCreate()
    {
        $app_identity = $this->apps->create(array(
            'name' => 'Test App Name'
        ));

        $this->assertNotEmpty($app_identity, 'app identity');
    }

    public function testFetch()
    {
        $app = $this->apps->fetch();

        $this->assertEquals($this->app_id, $app['id'], 'app id');
    }
}
