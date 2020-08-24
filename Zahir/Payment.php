<?php
require_once 'Session/CheckLogin.php';
require_once 'Session/SessionHelper.php';

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$token = SessionHelper::generateToken($url);

require_once 'ShowtimeXSLT.php';
require_once 'ShowtimeXPath.php';
require_once 'Booking/BookingXML.php';

require_once 'Decorator/LuxeDecorator.php';
require_once 'Decorator/DeluxeDecorator.php';
require_once 'Decorator/RegularDecorator.php';

require_once 'Classes/Hall.php';
require_once 'Classes/Ticket.php';
require_once 'Classes/Cart.php';

require_once 'Strategy/PaymentStrategy/CreditCardStrategy.php';
require_once 'Strategy/PaymentStrategy/PayPalStrategy.php';
require_once 'Strategy/SeatPriceStrategy/TwinSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/KidSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/RegularSeatStrategy.php';

require_once 'Utility/GeneralUtilities.php';

if (!isset($_SERVER['HTTP_REFERER']) || !SessionHelper::verifyToken($_SERVER['HTTP_REFERER'])) {
    header('Location:/tgx-cinemas/Home.php?csrf_token=invalid');
}

if (!filter_input(INPUT_GET, 'id')) {
    header('Location:/tgx-cinemas/Home.php?id=missing');
}

include_once 'Header.php';
include_once 'BookingTimer.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - Payment</title>
        <link rel="stylesheet" href="/tgx-cinemas/Zahir/css/Payment.css">
    </head>
    <body>
        <?php
        if (!isset($_GET['id'])) {
            exit(0);
        }

        $showtimeId = filter_input(INPUT_GET, 'id');
        $userId = SessionHelper::get('userId');

        $bookingXML = new BookingXML($userId);

        $xmlGenShowtime = new ShowtimeXSLT($showtimeId, "Booking/Booking" . $userId . ".xml");
        ?>

        <div class="order-summary-section">
            <h3><center>Order Summary</center></h3>

            <?php
            $showXpath = new ShowtimeXPath("Booking/Booking" . $userId . ".xml");
            $timeOfDay = GeneralUtilities::getTimeOfDay($showXpath->getTime($showtimeId));

            $baseHall = new Hall($showXpath->getBasePrice($showtimeId));

            foreach ($showXpath->getHallType($showtimeId) as $hallType) {
                switch ($hallType) {
                    case "Deluxe":
                        $baseHall = new DeluxeDecorator($baseHall, $timeOfDay);
                        break;
                    case "LUXE":
                        $baseHall = new LuxeDecorator($baseHall, $timeOfDay);
                        break;
                    case "Regular":
                        $baseHall = new RegularDecorator($baseHall, $timeOfDay);
                        break;
                    default:
                        echo "No Hall Type Found!";
                }
            }

            $cart = new Cart($showtimeId);

            $regularTicketPrice = new Ticket($baseHall->cost(), new RegularSeatStrategy());
            $kidTicketPrice = new Ticket($baseHall->cost(), new KidSeatStrategy());
            $twinTicketPrice = new Ticket($baseHall->cost(), new TwinSeatStrategy());

            $adultsCount = filter_input(INPUT_POST, 'adults');
            $kidsCount = filter_input(INPUT_POST, 'kids');
            $twinCount = filter_input(INPUT_POST, 'double');

            $bookingXML->addPeopleCount($adultsCount + $twinCount, $kidsCount);

            $bookingFile = "Booking/Booking" . $userId . ".xml";
            $doc = new DOMDocument();
            $doc->load($bookingFile);
            $doc->formatOutput = true;
            $xpath = new DOMXPath($doc);

            $indexAC = 0;

            for ($i = 0; $i < $adultsCount; $i++) {
                $indexAC = ++$indexAC;

                foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]") as $seat) {
                    $ticket = new Ticket($baseHall->cost(), new RegularSeatStrategy(), $seat->getAttribute('id'));
                    $cart->addTicket($ticket);

                    foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]/price") as $node) {
                        $node->parentNode->removeChild($node);
                    }

                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            for ($i = 0; $i < $kidsCount; $i++) {
                $indexAC = ++$indexAC;

                foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]") as $seat) {
                    $ticket = new Ticket($baseHall->cost(), new KidSeatStrategy(), $seat->getAttribute('id'));
                    $cart->addTicket($ticket);

                    foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]/price") as $node) {
                        $node->parentNode->removeChild($node);
                    }

                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            for ($i = 0; $i < $twinCount; $i++) {
                $index = $i;
                $index++;

                foreach ($xpath->evaluate("//seat[type='Double'][$index]") as $seat) {
                    $ticket = new Ticket($baseHall->cost(), new TwinSeatStrategy(), $seat->getAttribute('id'));
                    $cart->addTicket($ticket);

                    foreach ($xpath->evaluate("//seat[type='Double'][$index]/price") as $node) {
                        $node->parentNode->removeChild($node);
                    }

                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            $doc->save($bookingFile);

            $a = serialize($cart);
            $cartLocation = 'user_cart-' . sha1(base64_encode(random_bytes(10)));
            file_put_contents("Cart/" . $cartLocation, $a);
            SessionHelper::add('user_cart', $cartLocation);
            ?>

            <table style="width: 100%; margin: 5vh 0">
                <tr>
                    <td colspan="3">
                        <b style="color: red">ORDER SUMMARY</b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0.5vh; padding-top: 2vh">
                        Regular
                    </td>
                    <td style="text-align: center; padding-top: 2vh">
                        RM <?php echo number_format($regularTicketPrice->cost(), 2) . " X " . $adultsCount ?>
                    </td>
                    <td style="text-align: right; padding: 0 0.5vh; padding-top: 2vh">
                        RM <?php echo number_format($regularTicketPrice->cost() * $adultsCount, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0.5vh">
                        Kids
                    </td>
                    <td style="text-align: center">
                        RM <?php echo number_format($kidTicketPrice->cost(), 2) . " X " . $kidsCount ?>
                    </td>
                    <td style="text-align: right; padding: 0 0.5vh">
                        RM <?php echo number_format($kidTicketPrice->cost() * $kidsCount, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0.5vh; padding-bottom: 2vh">
                        Twin Seat
                    </td>
                    <td style="text-align: center; padding-bottom: 2vh">
                        RM <?php echo number_format($twinTicketPrice->cost(), 2) . " X " . $twinCount ?>
                    </td>
                    <td style="text-align: right; padding: 0 0.5vh; padding-bottom: 2vh">
                        RM <?php echo number_format($twinTicketPrice->cost() * $twinCount, 2) ?>
                    </td>
                </tr>
                <tr style="background-color: #eee;">
                    <td colspan="2" style="padding: 2vh 0.5vh; padding-right: 0 !important; margin-right: 0 !important">
                        Total
                    </td>
                    <td style="text-align: right; font-weight: 800; padding: 2vh 0.5vh;  padding-left: 0 !important; margin-left: 0 !important">
                        RM <?php echo number_format($cart->calculateTotal(), 2) ?>
                    </td>
                </tr>
            </table>

            <hr/>

            <h3 style="padding-top: 3vh;"><center>Make Payment</center></h3>
            <button class="accordion" style="margin-top: 3vh;">Credit/Debit Card</button>
            <div class="panel">
                <form action="Receipt.php" method="POST">
                    <table style="margin: 3vh 0;">
                        <tr>
                            <td>
                                Name on Card:
                            </td>
                            <td>
                                <input type="text" name="name" id="name" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Card Number: 
                            </td>
                            <td>
                                <input type="text" name="number" id="number" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                CVV:
                            </td>
                            <td>
                                <input type="text" name="cvv" id="cvv" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Expiry Date (MM/YY):
                            </td>
                            <td>
                                <input type="number" min="0" max="99" name="expMonth" id="expMonth" required/>
                                /
                                <input type="number" min="0" max="99" name="expYear" id="expYear" required />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="paymentMethod" value="credit" />
                                <button class="button-payment" style="margin: 2vh 0">Make Payment</button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" value="<?php echo $token ?>" id='csrf_token' name='csrf_token'/>
                </form>
            </div>

            <button class="accordion">PayPal</button>
            <div class="panel">
                <p>
                <form action="Receipt.php" method="POST">
                    <table style="margin: 3vh 0;">
                        <tr>
                            <td>
                                Email:
                            </td>
                            <td>
                                <input type="text" name="email" id="email" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Password: 
                            </td>
                            <td>
                                <input type="password" name="pass" id="pass" required />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="paymentMethod" value="paypal" />
                                <button class="button-payment" style="margin: 2vh 0">Make Payment</button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" value="<?php echo $token ?>" id='csrf_token' name='csrf_token'/>
                </form>
                </p>            
            </div>
        </div>
    </body>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
</html>
