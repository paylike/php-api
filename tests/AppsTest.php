<?php

namespace Paylike\Tests;

use Paylike\Resource\Apps;

class AppsTest extends BaseTest
{
    /**
     * @var Apps
     */
    protected $apps;

    public function setUp()
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

        $this->assertEquals($app['id'], $this->app_id, 'app id');
    }
}
