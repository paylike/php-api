<?php
/**
 * Created by PhpStorm.
 * User: calaraionut
 * Date: 12/5/18
 * Time: 3:57 PM
 */

namespace Paylike\Data;


class Currencies {


	/**
	 * Currencies constructor.
	 */
	public function __construct() {

	}


	/**
	 * @param $iso_code
	 *
	 * @return null
	 */
	public function getCurrency( $iso_code ) {

		$currencies = $this->all();
		if ( isset( $currencies[ $iso_code ] ) ) {
			return $currencies[ $iso_code ];
		}

		return null;
	}

	/**
	 * Return the number that should be used to compute cents from the total amount
	 *
	 * @param $currency_iso_code
	 *
	 * @return int|number
	 */
	public function getPaylikeMultiplier( $currency_iso_code ) {
		$currency = $this->getCurrency( $currency_iso_code );
		if ( isset( $currency['exponent'] ) ) {
			return pow( 10, $currency['exponent'] );
		} else {
			return pow( 10, 2 );
		}
	}

	/**
	 * Return the number that should be used to compute the total amount from cents
	 *
	 * @param $currency_iso_code
	 *
	 * @return int|number
	 */
	private function getPaylikeDivider( $currency_iso_code ) {
		return $this->getPaylikeMultiplier( $currency_iso_code );
	}

	/**
	 *
	 * @param  $amount
	 * @param  $currencyCode
	 *
	 * @return int
	 */
	public function ceil( $amount, $currencyCode ) {
		// in some cases float numbers cannot represented directly so they still have so decimals even
		// those are not shown. That causes ceil to increment the minor amount so we are using round with 3 digits
		// to clear that issue.
		// see http://php.net/manual/ro/function.ceil.php#117341
		return ceil( round( $amount, 3 ) * $this->getPaylikeMultiplier( $currencyCode ) );
	}


	/**
	 * @return array
	 */
	public function all() {
		return array(
			'AED' =>
				array(
					'code'     => 'AED',
					'currency' => 'United Arab Emirates dirham',
					'numeric'  => '784',
					'exponent' => 2,
				),
			'AFN' =>
				array(
					'code'     => 'AFN',
					'currency' => 'Afghan afghani',
					'numeric'  => '971',
					'exponent' => 2,
				),
			'ALL' =>
				array(
					'code'     => 'ALL',
					'currency' => 'Albanian lek',
					'numeric'  => '008',
					'exponent' => 2,
				),
			'AMD' =>
				array(
					'code'     => 'AMD',
					'currency' => 'Armenian dram',
					'numeric'  => '051',
					'exponent' => 2,
				),
			'ANG' =>
				array(
					'code'     => 'ANG',
					'currency' => 'Netherlands Antillean guilder',
					'numeric'  => '532',
					'exponent' => 2,
				),
			'AOA' =>
				array(
					'code'     => 'AOA',
					'currency' => 'Angolan kwanza',
					'numeric'  => '973',
					'exponent' => 2,
				),
			'ARS' =>
				array(
					'code'     => 'ARS',
					'currency' => 'Argentine peso',
					'numeric'  => '032',
					'exponent' => 2,
				),
			'AUD' =>
				array(
					'code'     => 'AUD',
					'currency' => 'Australian dollar',
					'numeric'  => '036',
					'exponent' => 2,
				),
			'AWG' =>
				array(
					'code'     => 'AWG',
					'currency' => 'Aruban florin',
					'numeric'  => '533',
					'exponent' => 2,
				),
			'AZN' =>
				array(
					'code'     => 'AZN',
					'currency' => 'Azerbaijani manat',
					'numeric'  => '944',
					'exponent' => 2,
				),
			'BAM' =>
				array(
					'code'     => 'BAM',
					'currency' => 'Bosnia and Herzegovina convertible mark',
					'numeric'  => '977',
					'exponent' => 2,
				),
			'BBD' =>
				array(
					'code'     => 'BBD',
					'currency' => 'Barbados dollar',
					'numeric'  => '052',
					'exponent' => 2,
				),
			'BDT' =>
				array(
					'code'     => 'BDT',
					'currency' => 'Bangladeshi taka',
					'numeric'  => '050',
					'exponent' => 2,
				),
			'BGN' =>
				array(
					'code'     => 'BGN',
					'currency' => 'Bulgarian lev',
					'numeric'  => '975',
					'exponent' => 2,
				),
			'BHD' =>
				array(
					'code'     => 'BHD',
					'currency' => 'Bahraini dinar',
					'numeric'  => '048',
					'exponent' => 3,
				),
			'BIF' =>
				array(
					'code'     => 'BIF',
					'currency' => 'Burundian franc',
					'numeric'  => '108',
					'exponent' => 0,
				),
			'BMD' =>
				array(
					'code'     => 'BMD',
					'currency' => 'Bermudian dollar',
					'numeric'  => '060',
					'exponent' => 2,
				),
			'BND' =>
				array(
					'code'     => 'BND',
					'currency' => 'Brunei dollar',
					'numeric'  => '096',
					'exponent' => 2,
				),
			'BOB' =>
				array(
					'code'     => 'BOB',
					'currency' => 'Boliviano',
					'numeric'  => '068',
					'exponent' => 2,
				),
			'BRL' =>
				array(
					'code'     => 'BRL',
					'currency' => 'Brazilian real',
					'numeric'  => '986',
					'exponent' => 2,
				),
			'BSD' =>
				array(
					'code'     => 'BSD',
					'currency' => 'Bahamian dollar',
					'numeric'  => '044',
					'exponent' => 2,
				),
			'BTN' =>
				array(
					'code'     => 'BTN',
					'currency' => 'Bhutanese ngultrum',
					'numeric'  => '064',
					'exponent' => 2,
				),
			'BWP' =>
				array(
					'code'     => 'BWP',
					'currency' => 'Botswana pula',
					'numeric'  => '072',
					'exponent' => 2,
				),
			'BYR' =>
				array(
					'code'     => 'BYR',
					'currency' => 'Belarusian ruble',
					'numeric'  => '974',
					'exponent' => 0,
				),
			'BZD' =>
				array(
					'code'     => 'BZD',
					'currency' => 'Belize dollar',
					'numeric'  => '084',
					'exponent' => 2,
				),
			'CAD' =>
				array(
					'code'     => 'CAD',
					'currency' => 'Canadian dollar',
					'numeric'  => '124',
					'exponent' => 2,
				),
			'CDF' =>
				array(
					'code'     => 'CDF',
					'currency' => 'Congolese franc',
					'numeric'  => '976',
					'exponent' => 2,
				),
			'CHF' =>
				array(
					'code'     => 'CHF',
					'currency' => 'Swiss franc',
					'numeric'  => '756',
					'funding'  => true,
					'exponent' => 2,
				),
			'CLP' =>
				array(
					'code'     => 'CLP',
					'currency' => 'Chilean peso',
					'numeric'  => '152',
					'exponent' => 0,
				),
			'CNY' =>
				array(
					'code'     => 'CNY',
					'currency' => 'Chinese yuan',
					'numeric'  => '156',
					'exponent' => 2,
				),
			'COP' =>
				array(
					'code'     => 'COP',
					'currency' => 'Colombian peso',
					'numeric'  => '170',
					'exponent' => 2,
				),
			'CRC' =>
				array(
					'code'     => 'CRC',
					'currency' => 'Costa Rican colon',
					'numeric'  => '188',
					'exponent' => 2,
				),
			'CUP' =>
				array(
					'code'     => 'CUP',
					'currency' => 'Cuban peso',
					'numeric'  => '192',
					'exponent' => 2,
				),
			'CVE' =>
				array(
					'code'     => 'CVE',
					'currency' => 'Cape Verde escudo',
					'numeric'  => '132',
					'exponent' => 2,
				),
			'CZK' =>
				array(
					'code'     => 'CZK',
					'currency' => 'Czech koruna',
					'numeric'  => '203',
					'exponent' => 2,
				),
			'DJF' =>
				array(
					'code'     => 'DJF',
					'currency' => 'Djiboutian franc',
					'numeric'  => '262',
					'exponent' => 0,
				),
			'DKK' =>
				array(
					'code'     => 'DKK',
					'currency' => 'Danish krone',
					'numeric'  => '208',
					'funding'  => true,
					'exponent' => 2,
				),
			'DOP' =>
				array(
					'code'     => 'DOP',
					'currency' => 'Dominican peso',
					'numeric'  => '214',
					'exponent' => 2,
				),
			'DZD' =>
				array(
					'code'     => 'DZD',
					'currency' => 'Algerian dinar',
					'numeric'  => '012',
					'exponent' => 2,
				),
			'EGP' =>
				array(
					'code'     => 'EGP',
					'currency' => 'Egyptian pound',
					'numeric'  => '818',
					'exponent' => 2,
				),
			'ERN' =>
				array(
					'code'     => 'ERN',
					'currency' => 'Eritrean nakfa',
					'numeric'  => '232',
					'exponent' => 2,
				),
			'ETB' =>
				array(
					'code'     => 'ETB',
					'currency' => 'Ethiopian birr',
					'numeric'  => '230',
					'exponent' => 2,
				),
			'EUR' =>
				array(
					'code'     => 'EUR',
					'currency' => 'Euro',
					'numeric'  => '978',
					'funding'  => true,
					'exponent' => 2,
				),
			'FJD' =>
				array(
					'code'     => 'FJD',
					'currency' => 'Fiji dollar',
					'numeric'  => '242',
					'exponent' => 2,
				),
			'FKP' =>
				array(
					'code'     => 'FKP',
					'currency' => 'Falkland Islands pound',
					'numeric'  => '238',
					'exponent' => 2,
				),
			'GBP' =>
				array(
					'code'     => 'GBP',
					'currency' => 'Pound sterling',
					'numeric'  => '826',
					'funding'  => true,
					'exponent' => 2,
				),
			'GEL' =>
				array(
					'code'     => 'GEL',
					'currency' => 'Georgian lari',
					'numeric'  => '981',
					'exponent' => 2,
				),
			'GHS' =>
				array(
					'code'     => 'GHS',
					'currency' => 'Ghanaian cedi',
					'numeric'  => '936',
					'exponent' => 2,
				),
			'GIP' =>
				array(
					'code'     => 'GIP',
					'currency' => 'Gibraltar pound',
					'numeric'  => '292',
					'exponent' => 2,
				),
			'GMD' =>
				array(
					'code'     => 'GMD',
					'currency' => 'Gambian dalasi',
					'numeric'  => '270',
					'exponent' => 2,
				),
			'GNF' =>
				array(
					'code'     => 'GNF',
					'currency' => 'Guinean franc',
					'numeric'  => '324',
					'exponent' => 0,
				),
			'GTQ' =>
				array(
					'code'     => 'GTQ',
					'currency' => 'Guatemalan quetzal',
					'numeric'  => '320',
					'exponent' => 2,
				),
			'GYD' =>
				array(
					'code'     => 'GYD',
					'currency' => 'Guyanese dollar',
					'numeric'  => '328',
					'exponent' => 2,
				),
			'HKD' =>
				array(
					'code'     => 'HKD',
					'currency' => 'Hong Kong dollar',
					'numeric'  => '344',
					'exponent' => 2,
				),
			'HNL' =>
				array(
					'code'     => 'HNL',
					'currency' => 'Honduran lempira',
					'numeric'  => '340',
					'exponent' => 2,
				),
			'HRK' =>
				array(
					'code'     => 'HRK',
					'currency' => 'Croatian kuna',
					'numeric'  => '191',
					'exponent' => 2,
				),
			'HTG' =>
				array(
					'code'     => 'HTG',
					'currency' => 'Haitian gourde',
					'numeric'  => '332',
					'exponent' => 2,
				),
			'HUF' =>
				array(
					'code'     => 'HUF',
					'currency' => 'Hungarian forint',
					'numeric'  => '348',
					'funding'  => true,
					'exponent' => 2,
				),
			'IDR' =>
				array(
					'code'     => 'IDR',
					'currency' => 'Indonesian rupiah',
					'numeric'  => '360',
					'exponent' => 2,
				),
			'ILS' =>
				array(
					'code'     => 'ILS',
					'currency' => 'Israeli new shekel',
					'numeric'  => '376',
					'exponent' => 2,
				),
			'INR' =>
				array(
					'code'     => 'INR',
					'currency' => 'Indian rupee',
					'numeric'  => '356',
					'exponent' => 2,
				),
			'IQD' =>
				array(
					'code'     => 'IQD',
					'currency' => 'Iraqi dinar',
					'numeric'  => '368',
					'exponent' => 3,
				),
			'IRR' =>
				array(
					'code'     => 'IRR',
					'currency' => 'Iranian rial',
					'numeric'  => '364',
					'exponent' => 2,
				),
			'ISK' =>
				array(
					'code'     => 'ISK',
					'currency' => 'Icelandic króna',
					'numeric'  => '352',
					'exponent' => 2,
				),
			'JMD' =>
				array(
					'code'     => 'JMD',
					'currency' => 'Jamaican dollar',
					'numeric'  => '388',
					'exponent' => 2,
				),
			'JOD' =>
				array(
					'code'     => 'JOD',
					'currency' => 'Jordanian dinar',
					'numeric'  => '400',
					'exponent' => 3,
				),
			'JPY' =>
				array(
					'code'     => 'JPY',
					'currency' => 'Japanese yen',
					'numeric'  => '392',
					'exponent' => 0,
				),
			'KES' =>
				array(
					'code'     => 'KES',
					'currency' => 'Kenyan shilling',
					'numeric'  => '404',
					'exponent' => 2,
				),
			'KGS' =>
				array(
					'code'     => 'KGS',
					'currency' => 'Kyrgyzstani som',
					'numeric'  => '417',
					'exponent' => 2,
				),
			'KHR' =>
				array(
					'code'     => 'KHR',
					'currency' => 'Cambodian riel',
					'numeric'  => '116',
					'exponent' => 2,
				),
			'KMF' =>
				array(
					'code'     => 'KMF',
					'currency' => 'Comoro franc',
					'numeric'  => '174',
					'exponent' => 0,
				),
			'KPW' =>
				array(
					'code'     => 'KPW',
					'currency' => 'North Korean won',
					'numeric'  => '408',
					'exponent' => 2,
				),
			'KRW' =>
				array(
					'code'     => 'KRW',
					'currency' => 'South Korean won',
					'numeric'  => '410',
					'exponent' => 0,
				),
			'KWD' =>
				array(
					'code'     => 'KWD',
					'currency' => 'Kuwaiti dinar',
					'numeric'  => '414',
					'exponent' => 3,
				),
			'KYD' =>
				array(
					'code'     => 'KYD',
					'currency' => 'Cayman Islands dollar',
					'numeric'  => '136',
					'exponent' => 2,
				),
			'KZT' =>
				array(
					'code'     => 'KZT',
					'currency' => 'Kazakhstani tenge',
					'numeric'  => '398',
					'exponent' => 2,
				),
			'LAK' =>
				array(
					'code'     => 'LAK',
					'currency' => 'Lao kip',
					'numeric'  => '418',
					'exponent' => 2,
				),
			'LBP' =>
				array(
					'code'     => 'LBP',
					'currency' => 'Lebanese pound',
					'numeric'  => '422',
					'exponent' => 2,
				),
			'LKR' =>
				array(
					'code'     => 'LKR',
					'currency' => 'Sri Lankan rupee',
					'numeric'  => '144',
					'exponent' => 2,
				),
			'LRD' =>
				array(
					'code'     => 'LRD',
					'currency' => 'Liberian dollar',
					'numeric'  => '430',
					'exponent' => 2,
				),
			'LSL' =>
				array(
					'code'     => 'LSL',
					'currency' => 'Lesotho loti',
					'numeric'  => '426',
					'exponent' => 2,
				),
			'MAD' =>
				array(
					'code'     => 'MAD',
					'currency' => 'Moroccan dirham',
					'numeric'  => '504',
					'exponent' => 2,
				),
			'MDL' =>
				array(
					'code'     => 'MDL',
					'currency' => 'Moldovan leu',
					'numeric'  => '498',
					'exponent' => 2,
				),
			'MGA' =>
				array(
					'code'     => 'MGA',
					'currency' => 'Malagasy ariary',
					'numeric'  => '969',
					'exponent' => 2,
				),
			'MKD' =>
				array(
					'code'     => 'MKD',
					'currency' => 'Macedonian denar',
					'numeric'  => '807',
					'exponent' => 2,
				),
			'MMK' =>
				array(
					'code'     => 'MMK',
					'currency' => 'Myanmar kyat',
					'numeric'  => '104',
					'exponent' => 2,
				),
			'MNT' =>
				array(
					'code'     => 'MNT',
					'currency' => 'Mongolian tögrög',
					'numeric'  => '496',
					'exponent' => 2,
				),
			'MOP' =>
				array(
					'code'     => 'MOP',
					'currency' => 'Macanese pataca',
					'numeric'  => '446',
					'exponent' => 2,
				),
			'MRO' =>
				array(
					'code'     => 'MRO',
					'currency' => 'Mauritanian ouguiya',
					'numeric'  => '478',
					'exponent' => 2,
				),
			'MUR' =>
				array(
					'code'     => 'MUR',
					'currency' => 'Mauritian rupee',
					'numeric'  => '480',
					'exponent' => 2,
				),
			'MVR' =>
				array(
					'code'     => 'MVR',
					'currency' => 'Maldivian rufiyaa',
					'numeric'  => '462',
					'exponent' => 2,
				),
			'MWK' =>
				array(
					'code'     => 'MWK',
					'currency' => 'Malawian kwacha',
					'numeric'  => '454',
					'exponent' => 2,
				),
			'MXN' =>
				array(
					'code'     => 'MXN',
					'currency' => 'Mexican peso',
					'numeric'  => '484',
					'exponent' => 2,
				),
			'MYR' =>
				array(
					'code'     => 'MYR',
					'currency' => 'Malaysian ringgit',
					'numeric'  => '458',
					'exponent' => 2,
				),
			'MZN' =>
				array(
					'code'     => 'MZN',
					'currency' => 'Mozambican metical',
					'numeric'  => '943',
					'exponent' => 2,
				),
			'NAD' =>
				array(
					'code'     => 'NAD',
					'currency' => 'Namibian dollar',
					'numeric'  => '516',
					'exponent' => 2,
				),
			'NGN' =>
				array(
					'code'     => 'NGN',
					'currency' => 'Nigerian naira',
					'numeric'  => '566',
					'exponent' => 2,
				),
			'NIO' =>
				array(
					'code'     => 'NIO',
					'currency' => 'Nicaraguan córdoba',
					'numeric'  => '558',
					'exponent' => 2,
				),
			'NOK' =>
				array(
					'code'     => 'NOK',
					'currency' => 'Norwegian krone',
					'numeric'  => '578',
					'funding'  => true,
					'exponent' => 2,
				),
			'NPR' =>
				array(
					'code'     => 'NPR',
					'currency' => 'Nepalese rupee',
					'numeric'  => '524',
					'exponent' => 2,
				),
			'NZD' =>
				array(
					'code'     => 'NZD',
					'currency' => 'New Zealand dollar',
					'numeric'  => '554',
					'exponent' => 2,
				),
			'OMR' =>
				array(
					'code'     => 'OMR',
					'currency' => 'Omani rial',
					'numeric'  => '512',
					'exponent' => 3,
				),
			'PAB' =>
				array(
					'code'     => 'PAB',
					'currency' => 'Panamanian balboa',
					'numeric'  => '590',
					'exponent' => 2,
				),
			'PEN' =>
				array(
					'code'     => 'PEN',
					'currency' => 'Peruvian Sol',
					'numeric'  => '604',
					'exponent' => 2,
				),
			'PGK' =>
				array(
					'code'     => 'PGK',
					'currency' => 'Papua New Guinean kina',
					'numeric'  => '598',
					'exponent' => 2,
				),
			'PHP' =>
				array(
					'code'     => 'PHP',
					'currency' => 'Philippine peso',
					'numeric'  => '608',
					'exponent' => 2,
				),
			'PKR' =>
				array(
					'code'     => 'PKR',
					'currency' => 'Pakistani rupee',
					'numeric'  => '586',
					'exponent' => 2,
				),
			'PLN' =>
				array(
					'code'     => 'PLN',
					'currency' => 'Polish złoty',
					'numeric'  => '985',
					'funding'  => true,
					'exponent' => 2,
				),
			'PYG' =>
				array(
					'code'     => 'PYG',
					'currency' => 'Paraguayan guaraní',
					'numeric'  => '600',
					'exponent' => 0,
				),
			'QAR' =>
				array(
					'code'     => 'QAR',
					'currency' => 'Qatari riyal',
					'numeric'  => '634',
					'exponent' => 2,
				),
			'RON' =>
				array(
					'code'     => 'RON',
					'currency' => 'Romanian leu',
					'numeric'  => '946',
					'funding'  => true,
					'exponent' => 2,
				),
			'RSD' =>
				array(
					'code'     => 'RSD',
					'currency' => 'Serbian dinar',
					'numeric'  => '941',
					'exponent' => 2,
				),
			'RUB' =>
				array(
					'code'     => 'RUB',
					'currency' => 'Russian ruble',
					'numeric'  => '643',
					'exponent' => 2,
				),
			'RWF' =>
				array(
					'code'     => 'RWF',
					'currency' => 'Rwandan franc',
					'numeric'  => '646',
					'exponent' => 0,
				),
			'SAR' =>
				array(
					'code'     => 'SAR',
					'currency' => 'Saudi riyal',
					'numeric'  => '682',
					'exponent' => 2,
				),
			'SBD' =>
				array(
					'code'     => 'SBD',
					'currency' => 'Solomon Islands dollar',
					'numeric'  => '090',
					'exponent' => 2,
				),
			'SCR' =>
				array(
					'code'     => 'SCR',
					'currency' => 'Seychelles rupee',
					'numeric'  => '690',
					'exponent' => 2,
				),
			'SDG' =>
				array(
					'code'     => 'SDG',
					'currency' => 'Sudanese pound',
					'numeric'  => '938',
					'exponent' => 2,
				),
			'SEK' =>
				array(
					'code'     => 'SEK',
					'currency' => 'Swedish krona',
					'numeric'  => '752',
					'funding'  => true,
					'exponent' => 2,
				),
			'SGD' =>
				array(
					'code'     => 'SGD',
					'currency' => 'Singapore dollar',
					'numeric'  => '702',
					'exponent' => 2,
				),
			'SHP' =>
				array(
					'code'     => 'SHP',
					'currency' => 'Saint Helena pound',
					'numeric'  => '654',
					'exponent' => 2,
				),
			'SLL' =>
				array(
					'code'     => 'SLL',
					'currency' => 'Sierra Leonean leone',
					'numeric'  => '694',
					'exponent' => 2,
				),
			'SOS' =>
				array(
					'code'     => 'SOS',
					'currency' => 'Somali shilling',
					'numeric'  => '706',
					'exponent' => 2,
				),
			'SRD' =>
				array(
					'code'     => 'SRD',
					'currency' => 'Surinamese dollar',
					'numeric'  => '968',
					'exponent' => 2,
				),
			'STD' =>
				array(
					'code'     => 'STD',
					'currency' => 'São Tomé and Príncipe dobra',
					'numeric'  => '678',
					'exponent' => 2,
				),
			'SYP' =>
				array(
					'code'     => 'SYP',
					'currency' => 'Syrian pound',
					'numeric'  => '760',
					'exponent' => 2,
				),
			'SZL' =>
				array(
					'code'     => 'SZL',
					'currency' => 'Swazi lilangeni',
					'numeric'  => '748',
					'exponent' => 2,
				),
			'THB' =>
				array(
					'code'     => 'THB',
					'currency' => 'Thai baht',
					'numeric'  => '764',
					'exponent' => 2,
				),
			'TJS' =>
				array(
					'code'     => 'TJS',
					'currency' => 'Tajikistani somoni',
					'numeric'  => '972',
					'exponent' => 2,
				),
			'TMT' =>
				array(
					'code'     => 'TMT',
					'currency' => 'Turkmenistani manat',
					'numeric'  => '934',
					'exponent' => 2,
				),
			'TND' =>
				array(
					'code'     => 'TND',
					'currency' => 'Tunisian dinar',
					'numeric'  => '788',
					'exponent' => 3,
				),
			'TOP' =>
				array(
					'code'     => 'TOP',
					'currency' => 'Tongan paʻanga',
					'numeric'  => '776',
					'exponent' => 2,
				),
			'TRY' =>
				array(
					'code'     => 'TRY',
					'currency' => 'Turkish lira',
					'numeric'  => '949',
					'exponent' => 2,
				),
			'TTD' =>
				array(
					'code'     => 'TTD',
					'currency' => 'Trinidad and Tobago dollar',
					'numeric'  => '780',
					'exponent' => 2,
				),
			'TWD' =>
				array(
					'code'     => 'TWD',
					'currency' => 'New Taiwan dollar',
					'numeric'  => '901',
					'exponent' => 2,
				),
			'TZS' =>
				array(
					'code'     => 'TZS',
					'currency' => 'Tanzanian shilling',
					'numeric'  => '834',
					'exponent' => 2,
				),
			'UAH' =>
				array(
					'code'     => 'UAH',
					'currency' => 'Ukrainian hryvnia',
					'numeric'  => '980',
					'exponent' => 2,
				),
			'UGX' =>
				array(
					'code'     => 'UGX',
					'currency' => 'Ugandan shilling',
					'numeric'  => '800',
					'exponent' => 0,
				),
			'USD' =>
				array(
					'code'     => 'USD',
					'currency' => 'United States dollar',
					'numeric'  => '840',
					'funding'  => true,
					'exponent' => 2,
				),
			'UYU' =>
				array(
					'code'     => 'UYU',
					'currency' => 'Uruguayan peso',
					'numeric'  => '858',
					'exponent' => 2,
				),
			'UZS' =>
				array(
					'code'     => 'UZS',
					'currency' => 'Uzbekistan som',
					'numeric'  => '860',
					'exponent' => 2,
				),
			'VEF' =>
				array(
					'code'     => 'VEF',
					'currency' => 'Venezuelan bolívar',
					'numeric'  => '937',
					'exponent' => 2,
				),
			'VND' =>
				array(
					'code'     => 'VND',
					'currency' => 'Vietnamese dong',
					'numeric'  => '704',
					'exponent' => 0,
				),
			'VUV' =>
				array(
					'code'     => 'VUV',
					'currency' => 'Vanuatu vatu',
					'numeric'  => '548',
					'exponent' => 0,
				),
			'WST' =>
				array(
					'code'     => 'WST',
					'currency' => 'Samoan tala',
					'numeric'  => '882',
					'exponent' => 2,
				),
			'XAF' =>
				array(
					'code'     => 'XAF',
					'currency' => 'CFA franc BEAC',
					'numeric'  => '950',
					'exponent' => 0,
				),
			'XCD' =>
				array(
					'code'     => 'XCD',
					'currency' => 'East Caribbean dollar',
					'numeric'  => '951',
					'exponent' => 2,
				),
			'XOF' =>
				array(
					'code'     => 'XOF',
					'currency' => 'CFA franc BCEAO',
					'numeric'  => '952',
					'exponent' => 0,
				),
			'XPF' =>
				array(
					'code'     => 'XPF',
					'currency' => 'CFP franc',
					'numeric'  => '953',
					'exponent' => 0,
				),
			'YER' =>
				array(
					'code'     => 'YER',
					'currency' => 'Yemeni rial',
					'numeric'  => '886',
					'exponent' => 2,
				),
			'ZAR' =>
				array(
					'code'     => 'ZAR',
					'currency' => 'South African rand',
					'numeric'  => '710',
					'exponent' => 2,
				),
			'ZMK' =>
				array(
					'code'     => 'ZMK',
					'currency' => 'Zambian kwacha',
					'numeric'  => '894',
					'exponent' => 2,
				),
			'ZWL' =>
				array(
					'code'     => 'ZWL',
					'currency' => 'Zimbabwean dollar',
					'numeric'  => '716',
					'exponent' => 2,
				),
		);
	}

}