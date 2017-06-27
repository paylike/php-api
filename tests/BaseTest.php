<?php

namespace Paylike\Tests;

use Paylike\Paylike;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paylike
     */
    protected $paylike;

    protected $app_id;
    protected $transaction_id;
    protected $merchant_id;

    public function setUp()
    {
        $this->paylike        = new Paylike("dbcf01af-8667-4967-9791-56101ca87ac8");
        $this->app_id         = "594d3cde5be12d547cbe2ec2";
        $this->transaction_id = "594d3d2cbe4728547d40150e";
        $this->merchant_id    = "594d3c455be12d547cbe2ebe";
    }
}
