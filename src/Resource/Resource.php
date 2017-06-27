<?php

namespace Paylike\Resource;

/**
 * Class Resource
 *
 * @package Paylike\Resource
 */
abstract class Resource
{
    /**
     * @var \Paylike\Paylike
     */
    protected $paylike;

    /**
     * Resource constructor.
     *
     * @param $paylike
     */
    function __construct($paylike)
    {
        $this->paylike = $paylike;
    }
}
