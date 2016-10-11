<?php
session_start();
include_once( 'Paylike/Client.php' );
$privateAppKey = 'c0d3d84c-4ced-4f07-963f-f3e5b6196e75';
$publicKey     = '6bb16eb9-de0f-4224-9bc1-3d2b35b0bccd';
$amount        = 5000; //cents;
$currency      = 'GBP';
if ( isset( $_POST['action'] ) ) {
    \Paylike\Client::setKey( $privateAppKey );
    $transactionId             = $_POST['transactionId'];
    $_SESSION['transactionId'] = $transactionId;
    switch ( $_POST['action'] ) {
        case "voidTransactionFull":
            $data     = array( 'amount' => $amount );
            $response = \Paylike\Transaction::void( $transactionId, $data );
            break;
        case "voidTransactionHalf":
            $data     = array( 'amount' => $amount / 2 );
            $response = \Paylike\Transaction::void( $transactionId, array( 'amount' => $data ) );
            break;
        case "fetchTransaction":
            $response = \Paylike\Transaction::fetch( $transactionId );
            break;
        case "captureTransactionFull":
            $data     = array(
                'amount'   => $amount / 2,
                'currency' => $currency
            );
            $response = \Paylike\Transaction::capture( $transactionId, $data );
            break;
        case "captureTransactionHalf":
            $data     = array(
                'amount'   => $amount / 2,
                'currency' => $currency
            );
            $response = \Paylike\Transaction::capture( $transactionId, $data );
            break;
        case "refundTransactionFull":
            $data     = array(
                'amount'     => $amount,
                'descriptor' => $_POST['reason']
            );
            $response = \Paylike\Transaction::refund( $transactionId, $data );
            break;
        case "refundTransactionHalf":
            $data     = array(
                'amount'     => $amount / 2,
                'descriptor' => $_POST['reason']
            );
            $response = \Paylike\Transaction::refund( $transactionId, $data );
            break;
    }
}
if ( ! isset( $transactionId ) ) {
    if ( isset( $_SESSION['transactionId'] ) ) {
        $transactionId = $_SESSION['transactionId'];
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
    var paylike = Paylike('<?php echo $publicKey;?>');

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
            jQuery(".transactionId").val(trxid);
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
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="voidTransactionFull">
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
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="voidTransactionHalf">
    <input type="submit" value="Test Void"/>
</form>
<br/>
<form method="POST">
    <h4>
        Fetch transaction.
    </h4>
    <label>
        Transaction id
    </label>
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="fetchTransaction">
    <input type="submit" value="Test Transaction fetch"/>
</form>
<br/>
<form method="POST">
    <h4>
        Capture the transaction for the full amount
    </h4>
    <label>
        Transaction id
    </label>
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="captureTransactionFull">
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
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="captureTransactionHalf">
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
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId"><br/>
    <label>
        Reason for the refund(optional)
    </label>
    <input type="text" name="reason">
    <input type="hidden" name="action" value="refundTransactionFull">
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
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId"><br/>
    <label>
        Reason for the refund(optional)
    </label>
    <input type="text" name="reason">
    <input type="hidden" name="action" value="refundTransactionHalf">
    <input type="submit" value="Test Refund"/>
</form>
</body>
</html>
