<?php

class Paylike {
	private $key;

	// subsystems
	private $transactions;

	public function __construct( $key ){
		$this->key = $key;
	}

	public function setKey( $key ){
		$this->key = $key;
	}

	public function getKey(){
		return $this->key;
	}

	public function __get( $name ){
		switch ($name) {
			case 'transactions':
				if (!$this->transactions)
					$this->transactions = new PaylikeTransactions($this);

				return $this->transactions;

			default:
				throw new BadPropertyException($this, $name);
		}
    }
}

class PaylikeTransactions extends PaylikeSubsystem {
	public function fetch( $transactionId ){
		return $this->request('GET', '/transactions/'.$transactionId);
	}

	public function capture( $transactionId, $opts ){
		return $this->request('POST', '/transactions/'.$transactionId.'/captures', $opts);
	}

	public function refund( $transactionId, $opts ){
		return $this->request('POST', '/transactions/'.$transactionId.'/refunds', $opts);
	}
}

class PaylikeSubsystem {
	private $paylike;

	public function __construct( $paylike ){
		$this->paylike = $paylike;
	}

	protected function request( $verb, $path, $data = null ){
		$c = curl_init();

		curl_setopt($c, CURLOPT_URL, 'https://api.paylike.io'.$path);

		if ($this->paylike->getKey() !== null)
			curl_setopt($c, CURLOPT_USERPWD, ':'.$this->paylike->getKey());

		if (in_array($verb, [ 'POST', 'PUT', 'PATCH' ]))
			curl_setopt($c, CURLOPT_POSTFIELDS, $data);

		if (in_array($verb, [ 'GET', 'POST' ]))
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

		$raw = curl_exec($c);

		$code = curl_getinfo($c, CURLINFO_HTTP_CODE);

		curl_close($c);

		if ($code < 200 || $code > 299)
			return false;

		if ($code === 204)	// No Content
			return true;

		return json_decode($raw);
	}
}
