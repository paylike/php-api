<?php
session_start();
include_once( 'Paylike/Client.php' );
$privateAppKey = 'c0d3d84c-4ced-4f07-963f-f3e5b6196e75';
$publicKey     = '6bb16eb9-de0f-4224-9bc1-3d2b35b0bccd';
$amount        = 5000; //cents;
$currency      = 'GBP';
if ( isset( $_POST['action'] ) ) {
    \Paylike\Client::setKey( $privateAppKey );
    $transactionId = $cardId = null;
    if ( isset( $_POST['transactionId'] ) ) {
        $transactionId             = $_POST['transactionId'];
        $_SESSION['transactionId'] = $transactionId;
    }
    if ( isset( $_POST['cardId'] ) ) {
        $cardId             = $_POST['cardId'];
        $_SESSION['cardId'] = $cardId;
    }
    switch ( $_POST['action'] ) {
        case "voidTransactionFull":
            $data     = array( 'amount' => $amount );
            $response = \Paylike\Transaction::void( $transactionId, $data );
            break;
        case "voidTransactionHalf":
            $data     = array( 'amount' => $amount / 2 );
            $response = \Paylike\Transaction::void( $transactionId, array( 'amount' => $data ) );
            break;
        case "createTransaction":
            $transaction = \Paylike\Transaction::fetch( $transactionId );
            $merchantId  = $transaction['transaction']['merchantId'];
            $data        = array(
                'transactionId' => $transactionId,
                'amount'        => $amount,
                'currency'      => $currency,
                'custom'        => array(
                    'email' => 'ionut@derikon.com'
                )
            );
            $response    = \Paylike\Transaction::create( $merchantId, $data );
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
        case "fetchCard":
            $response = \Paylike\Card::fetch( $cardId );
            break;
    }
}
if ( ! isset( $transactionId ) ) {
    if ( isset( $_SESSION['transactionId'] ) ) {
        $transactionId = $_SESSION['transactionId'];
    }
}
if ( ! isset( $cardId ) ) {
    if ( isset( $_SESSION['cardId'] ) ) {
        $cardId = $_SESSION['cardId'];
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
    if ( isset( $_POST['cardId'] ) ) {
        if ( isset( $response['card']['id'] ) && $response['card']['id'] ) {
            echo '<div style="color:rgb(69, 110, 16)">Card operation was successful.</div>';
        } else {
            echo '<div style="color:#fe171d">Card operation failed.</div>';
        }
    } else {
        if ( isset( $response['transaction']['id'] ) && $response['transaction']['id'] ) {
            echo '<div style="color:rgb(69, 110, 16)">Transaction operation was successful.</div>';
        } else {
            echo '<div style="color:#fe171d">Transaction operation failed.</div>';
        }
    }
    echo '</div>';
}
?>
<button onclick="pay();">Get transaction id</button>
<button onclick="tokenize();">Get card id</button>
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
                email: 'ionut@derikon.com'
            }
        }, function (err, res) {
            if (err)
                return console.warn(err);
            var trxid = res.transaction.id;
            jQuery(".transactionId").val(trxid);
        });
    }

    function tokenize() {

        paylike.popup({
            title: 'Testing the card tokenize',
            custom: {
                orderNo: 'Test Order',
                email: 'ionut@derikon.com'
            }
        }, function (err, res) {
            if (err)
                return console.warn(err);
            var crxid = res.card.id;
            jQuery(".cardId").val(crxid);
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
        Create a new transaction based on a previous one.
    </h4>
    <label>
        Transaction id
    </label>
    <input type="text" name="transactionId" <?php if ( isset( $transactionId ) ) {
        echo 'value="' . $transactionId . '"';
    } ?> class="transactionId">
    <input type="hidden" name="action" value="createTransaction">
    <input type="submit" value="Test Transaction create"/>
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
<br/>
<form method="POST">
    <h4>
        Fetch card.
    </h4>
    <label>
        Card id
    </label>
    <input type="text" name="cardId" <?php if ( isset( $cardId ) ) {
        echo 'value="' . $cardId . '"';
    } ?> class="cardId">
    <input type="hidden" name="action" value="fetchCard">
    <input type="submit" value="Test Card fetch"/>
</form>
</body>
</html>
