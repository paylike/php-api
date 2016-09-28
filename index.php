<?php
session_start();
include_once( 'PaylikeApiWrapper/Paylike.php' );
$private_app_key = 'c0d3d84c-4ced-4f07-963f-f3e5b6196e75';
$public_key      = '6bb16eb9-de0f-4224-9bc1-3d2b35b0bccd';
$amount          = 5000; //cents;
$currency        = 'GBP';
if ( isset( $_POST['action'] ) ) {
	\PaylikeApps\Paylike::setKey( $private_app_key );
	$transaction_id             = $_POST['transaction_id'];
	$_SESSION['transaction_id'] = $transaction_id;
	switch ( $_POST['action'] ) {
		case "void_transaction_full":
			$response = \PaylikeApps\Paylike::void( $transaction_id, $amount );
			break;
		case "void_transaction_half":
			$response = \PaylikeApps\Paylike::void( $transaction_id, $amount / 2 );
			break;
		case "check_transaction_authorization":
			$response = \PaylikeApps\Paylike::authorize( $transaction_id );
			break;
		case "capture_transaction_full":
			$response = \PaylikeApps\Paylike::capture( $transaction_id, $amount, $currency );
			break;
		case "capture_transaction_half":
			$response = \PaylikeApps\Paylike::capture( $transaction_id, $amount / 2, $currency );
			break;
		case "refund_transaction_full":
			$response = \PaylikeApps\Paylike::refund( $transaction_id, $amount, $_POST['reason'] );
			break;
		case "refund_transaction_half":
			$response = \PaylikeApps\Paylike::refund( $transaction_id, $amount / 2, $_POST['reason'] );
			break;
	}
}
if ( ! isset( $transaction_id ) ) {
	if ( isset( $_SESSION['transaction_id'] ) ) {
		$transaction_id = $_SESSION['transaction_id'];
	}
}
?>
<html>
<head>
	<title>Paylike test</title>
	<link type="text/css" href="css/normalize.css"/>
	<link type="text/css" href="css/main.css"/>
</head>
<body>
<h2>
	Test Paylike Api Wrapper
</h2>
<br/>
<?php
if ( isset( $response ) ) {
	echo '<div id="result"><pre>';
	print_r( $response );
	echo '</pre>';
	if ( isset( $response['transaction']['successful'] ) && $response['transaction']['successful'] ) {
		echo '<div style="color:rgb(69, 110, 16)">Operation was successful.</div>';
	} else {
		echo '<div style="color:#fe171d">Operation failed.</div>';
	}
	echo '</div>';
}
?>
<button onclick="pay();">Get transaction id</button>
<script src="https://sdk.paylike.io/3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	var paylike = Paylike('<?php echo $public_key ;?>');

	function pay() {

		paylike.popup({
			title: 'Testing the payment',
			currency: '<?php echo $currency; ?>',
			amount: <?php echo $amount; ?>,
			custom: {
				orderNo: 'Test Order',
				email: 'ionut@derikon.com',
			},
		}, function (err, res) {
			if (err)
				return console.warn(err);
			var trxid = res.transaction.id;
			jQuery(".transaction_id").val(trxid);
		});
	}
</script>
<br/>

<form method="POST">
	<h4>
		Void the transaction for the entire amount
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id">
	<input type="hidden" name="action" value="void_transaction_full">
	<input type="submit" value="Test Void"/>
</form>
<br/>

<form method="POST">
	<h4>
		Void the transaction for half of amount
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id">
	<input type="hidden" name="action" value="void_transaction_half">
	<input type="submit" value="Test Void"/>
</form>
<br/>

<form method="POST">
	<h4>
		Check authorization
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id">
	<input type="hidden" name="action" value="check_transaction_authorization">
	<input type="submit" value="Test Authorization"/>
</form>
<br/>

<form method="POST">
	<h4>
		Capture the transaction for the full amount
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id">
	<input type="hidden" name="action" value="capture_transaction_full">
	<input type="submit" value="Test Capture"/>
</form>
<br/>

<form method="POST">
	<h4>
		Capture the transaction for the half of the amount
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id">
	<input type="hidden" name="action" value="capture_transaction_half">
	<input type="submit" value="Test Capture"/>
</form>
<form method="POST">
	<h4>
		Refund the transaction for the full amount
		<br/>
		<small><i>
				Only works when you have previously captured the amount.
			</i></small>
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id"><br/>
	<label>
		Reason for the refund(optional)
	</label>
	<input type="text" name="reason">
	<input type="hidden" name="action" value="refund_transaction_full">
	<input type="submit" value="Test Refund"/>
</form>
<br/>

<form method="POST">
	<h4>
		Capture the transaction for the half of the amount
		<br/>
		<small><i>
				Only works when you have previously captured the amount.
			</i></small>
	</h4>
	<label>
		Transaction id
	</label>
	<input type="text" name="transaction_id" <?php if ( isset( $transaction_id ) ) {
		echo 'value="' . $transaction_id . '"';
	} ?> class="transaction_id"><br/>
	<label>
		Reason for the refund(optional)
	</label>
	<input type="text" name="reason">
	<input type="hidden" name="action" value="refund_transaction_half">
	<input type="submit" value="Test Refund"/>
</form>
</body>
</html>
