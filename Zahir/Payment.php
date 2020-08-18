<?php
require_once 'ShowtimeXSLT.php';
require_once 'Booking/BookingXML.php';
require_once 'Decorator/BaseHall.php';
require_once 'Decorator/LuxeDecorator.php';
require_once 'Decorator/DeluxeDecorator.php';
require_once 'Decorator/RegularDecorator.php';
require_once 'Decorator/TIME_OF_DAY.php';
require_once 'Strategy/Ticket.php';
require_once 'Strategy/Cart.php';
require_once 'Strategy/PaymentStrategy/CreditCardStrategy.php';
require_once 'Strategy/PaymentStrategy/PayPalStrategy.php';
require_once 'Strategy/SeatPriceStrategy/TwinSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/KidSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/RegularSeatStrategy.php';
require_once 'ShowtimeXPath.php';
require_once 'GeneralUtilities.php';

define("BASE_PRICE", 5);

session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Payment.css">
    </head>
    <body>
        <?php
        //echo $_POST['adults'];
        //Display Order Summary https://i.imgur.com/T7Aje7g.png
        //Display PayPal and Credit Card Payment
        //Ticket : https://i.imgur.com/2ikZXWk.png
        ?>

        <?php
        if (isset($_GET['id'])) {
            $showtimeId = $_GET['id'];
            $xmlGenShowtime = new ShowtimeXSLT($showtimeId);
            $bookingXML = new BookingXML($_SESSION['userId']);
            $bookingXML->createBookingElement($showtimeId);
            $bookingXML->createSeatElement();

            //Generate Booking.xml for the User
            //Append the Showtime.xml inside the Booking.xml as a Child Node
            //Append the UsersSeats[userID].xml inside the Booking.xml as a Child node
            //Calculate the price of the ticket using Hall Decorator -> 1. Get The Hall Type -> 2. Apply the appropriate decorator
            //Add price element inside the Booking.xml for each seat
            //Have 2 buttons for Payment (paypal and credit card)
            //TODO: Upon submission Add Payment Method to Booking.xml
            //TODO: Proceed to Receipt page
            //This is just an idea. You could have Ticket Decorator for Kids, Adults and Double Seat... Zahir from yesterday: I just added SeatType to hall LOL.
        }
        ?>

        <div class="order-summary-section">
            <h3><center>Order Summary</center></h3>

            <?php
            $showXpath = new ShowtimeXPath("Booking/Booking" . $_SESSION['userId'] . ".xml");
            $timeOfDay = GeneralUtilities::getTimeOfDay($showXpath->getTime($showtimeId));

            $baseHall = new BaseHall(BASE_PRICE, $timeOfDay);

            foreach ($showXpath->getHallType($showtimeId) as $hallType) {
                switch ($hallType) {
                    case "Deluxe":
                        $baseHall = new DeluxeDecorator($baseHall);
                        break;
                    case "LUXE":
                        $baseHall = new LuxeDecorator($baseHall);
                        break;
                    case "Regular":
                        $baseHall = new RegularDecorator($baseHall);
                        break;
                    default:
                        echo "No Hall Type Found!";
                }
            }

            $cart = new Cart();


            $regularTicketPrice = new Ticket($baseHall->cost(), new RegularSeatStrategy());
            $kidTicketPrice = new Ticket($baseHall->cost(), new KidSeatStrategy());
            $twinTicketPrice = new Ticket($baseHall->cost(), new TwinSeatStrategy());

            //echo "Adults: <span style='padding-right: 5vh'></span> RM" . $regularTicketPrice->cost() . " X " . $_POST['adults'] . "<br/>";
            //echo "Kids: <span style='padding-right: 5vh'></span> RM" . $kidTicketPrice->cost() . " X " . $_POST['kids'] . "<br/>";
            //echo "Twin: <span style='padding-right: 5vh'></span> RM" . $twinTicketPrice->cost() . " X " . $_POST['double'] . "<br/><br/>";

            $adultsCount = $_POST['adults'];
            $kidsCount = $_POST['kids'];
            $twinCount = $_POST['double'];

            $bookingFile = "Booking/Booking" . $_SESSION['userId'] . ".xml";
            $doc = new DOMDocument();
            $doc->load($bookingFile);
            $doc->formatOutput = true;
            $xpath = new DOMXPath($doc);

            $indexAC = 0;

            for ($i = 0; $i < $adultsCount; $i++) {
                $ticket = new Ticket($baseHall->cost(), new RegularSeatStrategy());
                $cart->addTicket($ticket);

                $indexAC = ++$indexAC;

                foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]") as $seat) {
                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            for ($i = 0; $i < $kidsCount; $i++) {
                $ticket = new Ticket($baseHall->cost(), new KidSeatStrategy());
                $cart->addTicket($ticket);

                $indexAC = ++$indexAC;

                foreach ($xpath->evaluate("//seat[type='Regular'][$indexAC]") as $seat) {
                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            for ($i = 0; $i < $twinCount; $i++) {
                $ticket = new Ticket($baseHall->cost(), new TwinSeatStrategy());
                $cart->addTicket($ticket);

                $index = ++$i;
                foreach ($xpath->evaluate("//seat[type='Double'][$index]") as $seat) {
                    $seat->appendChild($doc->createElement('price', $ticket->cost()));
                }
            }

            $doc->save($bookingFile);
            
            //Save Cart to Session
            
            $_SESSION['userCart'] = $cart;

            //echo "Total: RM" . $cart->calculateTotal();

            //$cart->pay(new PayPalStrategy("myemail@example.com", "mypwd"));
            //$cart->pay(new CreditCardStrategy("Zahir Sher", "9999 9999 9999 9999", "999", "08/24"));
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
                                <input type="text" name="name" id="name" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Card Number: 
                            </td>
                            <td>
                                <input type="text" name="number" id="number" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                CVV:
                            </td>
                            <td>
                                <input type="text" name="cvv" id="cvv" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Expiry Date (MM/YY):
                            </td>
                            <td>
                                <input type="number" min="0" max="99" name="expMonth" id="expMonth"/>/<input type="number" min="0" max="99" name="expYear" id="expYear" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="paymentMethod" value="credit" />
                                <button class="button" style="margin: 2vh 0">Make Payment</button>
                            </td>
                        </tr>
                    </table>
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
                                <input type="text" name="email" id="email" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Password: 
                            </td>
                            <td>
                                <input type="password" name="pass" id="pass" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="paymentMethod" value="paypal" />
                                <button class="button" style="margin: 2vh 0">Make Payment</button>
                            </td>
                        </tr>
                    </table>
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
