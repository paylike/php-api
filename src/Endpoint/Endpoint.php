<?php

namespace Paylike\Endpoint;

/**
 * Class Endpoint
 *
 * @package Paylike\Endpoint
 */
abstract class Endpoint
{
    /**
     * @var \Paylike\Paylike
     */
    protected $paylike;

    /**
     * Endpoint constructor.
     *
     * @param $paylike
     */
    function __construct($paylike)
    {
        $this->paylike = $paylike;
    }
}
