<?php

namespace Paylike\Tests;

use Paylike\Paylike;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * @var Paylike
     */
    protected $paylike;

    protected $app_id;
    protected $transaction_id;
    protected $merchant_id;

    public function setUp(): void
    {
        $this->paylike        = new Paylike("a61437c5-1043-443b-ac3a-fe49c2b58481");
        $this->app_id         = "601268435b1f7e3d1ebf8271";
        $this->transaction_id = "63ca94a11ec6fb693b1da497";
        $this->merchant_id    = "601267ebf700a44f17ee4fbf";
    }

}
