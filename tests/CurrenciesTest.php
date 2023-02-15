<?php

namespace Paylike\Tests;

use Paylike\Data\Currencies;
use Paylike\Exception\NotFound;

class CurrenciesTest extends BaseTest {
	/**
	 * @var Currencies
	 */
	protected $currency;

	/**
	 *
	 */
	public function setUp():void {
		parent::setUp();
		$this->currency = new Currencies();
	}


	/**
	 *
	 */
	public function testGet() {
		$currency = $this->currency->getCurrency( 'DKK' );
		$this->assertTrue( ( $currency['exponent'] == 2 ));
	}

	/**
	 *
	 */
	public function testCeil() {
		$value = $this->currency->ceil( 2.35, 'DKK' );
		$this->assertTrue( ( $value == 235 ) );
	}
}
