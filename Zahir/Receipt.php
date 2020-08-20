<?php
require_once 'Classes/Cart.php';
require_once 'Session/CheckLogin.php';
require_once 'Session/SessionHelper.php';

require_once 'Booking/BookingXML.php';

require_once 'Classes/Ticket.php';
require_once 'Classes/User.php';

require_once 'Strategy/PaymentStrategy/CreditCardStrategy.php';
require_once 'Strategy/PaymentStrategy/PayPalStrategy.php';
require_once 'Strategy/SeatPriceStrategy/TwinSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/KidSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/RegularSeatStrategy.php';

require_once 'ReceiptXSLT.php';
require_once 'Booking/BookingDOMParser.php';

require_once '../Database/BookingConnection.php';

include_once 'Header.php';

if (!SessionHelper::verifyToken('receipt')) {
    header('Location:/Assignment/Simran/Home.php');
}

$cartLocation = SessionHelper::get('user_cart');
$a = file_get_contents("Cart/" . $cartLocation);
$cart = unserialize($a);
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
        $userId = SessionHelper::get('userId');
        $paymentMethod = filter_input(INPUT_POST, 'paymentMethod');
        $bookingXML = new BookingXML($userId);

        switch ($paymentMethod) {
            case 'credit':
                $method = new CreditCardStrategy(filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'number'), filter_input(INPUT_POST, 'cvv'), filter_input(INPUT_POST, 'expMonth'), filter_input(INPUT_POST, 'expYear'));
                $bookingXML->addPaymentMethod("Credit Card", $method->getName(), $cart->calculateTotal());
                break;
            case 'paypal':
                $method = new PayPalStrategy(filter_input(INPUT_POST, 'email'), filter_input(INPUT_POST, 'pass'));
                $bookingXML->addPaymentMethod("PayPal", $method->getEmail(), $cart->calculateTotal());
                break;
            default:
                echo "No Payment Method Found!";
        }

        $receiptXSLT = new ReceiptXSLT($userId);
        $cart->pay($method, $userId, $cart);
        
        SessionHelper::remove('selectedSeats');
        SessionHelper::remove('user_cart');
        SessionHelper::removeToken('seatcount_payment');
        SessionHelper::removeToken('receipt');
        
        unlink("Cart/" . $cartLocation);
        unlink("SelectedSeats/SelectedSeats" . $userId . ".xml");
        unlink("Booking/Booking" . $userId . ".xml");
        ?>
    </body>
</html>
