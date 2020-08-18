<?php
require_once 'Booking/BookingXML.php';
require_once 'Decorator/TIME_OF_DAY.php';
require_once 'Strategy/Ticket.php';
require_once 'Strategy/Cart.php';
require_once 'Strategy/PaymentStrategy/CreditCardStrategy.php';
require_once 'Strategy/PaymentStrategy/PayPalStrategy.php';
require_once 'Strategy/SeatPriceStrategy/TwinSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/KidSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/RegularSeatStrategy.php';
require_once 'ReceiptXSLT.php';

session_start();

$cart = new Cart();
$cart = $_SESSION['userCart'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="Receipt.css"/>
    </head>
    <body>
        

        <?php
        $userId = $_SESSION['userId'];
        $paymentMethod = $_POST['paymentMethod'];
        $bookingXML = new BookingXML($userId);

        switch ($paymentMethod) {
            case 'credit':
                $creditCard = new CreditCardStrategy("Zahir Sher", "9999 9999 9999 9999", "999", "08/24");
                $cart->pay($creditCard);
                $bookingXML->addPaymentMethod("Credit Card", $creditCard->getName(), $cart->calculateTotal());
                break;
            case 'paypal':
                $paypal = new PayPalStrategy("myemail@example.com", "mypwd");
                $cart->pay($paypal);
                $bookingXML->addPaymentMethod("PayPal", $paypal->getEmail(), $cart->calculateTotal());
                break;
            default:
                echo "No Payment Method Found!";
        }
        
        $receiptXSLT = new ReceiptXSLT($userId);
        ?>
    </body>
</html>
