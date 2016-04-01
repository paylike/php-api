<?php

require_once 'client.php';

$paylike = new Paylike('Your app key here (not public key)');

$capture = $paylike->transactions->capture('put a transaction ID here', [
	// GBP 5.99
	'currency' => 'GBP',
	'amount' => 599,
]);

if ($capture)
	echo 'Successfully captured transaction';

var_dump($paylike->transactions->fetch('put a transaction ID here'));
