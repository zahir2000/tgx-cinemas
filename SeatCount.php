<?php
require_once 'ShowtimeXSLT.php';
require_once 'ShowtimeXPath.php';
require_once 'UserSeats/UserSeats.php';
require_once 'UserSeats/UserSeatsXPath.php';

require_once 'Booking/Booking.php';
require_once 'Booking/BookingXML.php';
require_once 'Booking/User.php';

session_start();

$_SESSION['userId'] = 1;

/* if (isset($_SESSION['selectedSeats'])) {
  $array = $_SESSION['selectedSeats'];

  for ($x = 0, $max = count($array); $x < $max; ++$x) {
  echo $array[$x];
  }
  } */

if (!isset($_GET['id'])) {
    return;
}

$showtimeId = $_GET['id'];
$userId = $_SESSION['userId'];

$userSeats = new UserSeats($userId);
$userSeatsCount = new UserSeatsXPath('UserSeats/UserSeats' . $userId . '.xml');

$bookingXML = new BookingXML($userId);
$bookingXML->createBookingElement($showtimeId);
$bookingXML->createSeatElement();

$xmlGenShowtime = new ShowtimeXSLT($showtimeId, 'Booking/Booking' . $userId . '.xml');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - Payment</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <style>
            .ticket-selection {
                background-color: #FFF;
                padding: 40px;
                box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -webkit-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -moz-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                transition: all 0.7s ease;
                width: 90%;
                /* height: 100vh; */
                margin: 0 auto;
                margin-top: 3vh;
            }

            .button {
                text-align: center;
                padding-top: 4vh;
            }

            .button button {
                background-color: grey;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                transition: all 0.7s ease;
                cursor: pointer;
            }

            .button button:hover{
                background-color: black;
            }
        </style>

        <script>
            var total = <?php echo $userSeatsCount->getRegularSeatCount() ?>;
            function Adults_ValueChanged(element) {
                document.getElementById("kids").max = total - element.value;
            }

            function Kids_ValueChanged(element) {
                document.getElementById("adults").max = total - element.value;
            }

            $('document').ready(function () {
                var doubleSeatCount = <?php echo $userSeatsCount->getDoubleSeatCount() ?>;
                if (doubleSeatCount > 0) {
                    document.getElementById("doubleSeat").style.display = "block";
                }

                if (total > 0) {
                    document.getElementById("regularSeat").style.display = "block";
                }
            });
        </script>
    </head>
    <body>
        <div class="ticket-selection">
            <?php
            $showtimeXpath = new ShowtimeXPath('Showtime.xml');
            $hallType = $showtimeXpath->getHallType($showtimeId);
            ?>

            <form method="post" action="Payment.php?id=<?php echo $showtimeId ?>">
                <div id="regularSeat" style="display:none">
                    <h3>Regular Seat</h3>
                    <div style="padding-bottom: 2vh;">
                        <label for = "adults">Classic:</label>
                        <input type = "number" id = "adults" name="adults" step = "1" min="1" onchange="Adults_ValueChanged(this)" max="<?php echo $userSeatsCount->getRegularSeatCount() ?>" value="<?php echo $userSeatsCount->getRegularSeatCount() ?>">
                    </div>

                    <div>
                        <label for = "kids">Kids:</label>
                        <input type = "number" id= "kids" name="kids" step = "1" min="0" value="0" onchange="Kids_ValueChanged(this)" max="<?php echo $userSeatsCount->getRegularSeatCount() ?>">
                    </div>
                </div>

                <div id="doubleSeat" style="display: none">
                    <h3 style="padding-top:2vh;">Double Seat</h3>
                    <div style="padding-bottom: 2vh;">
                        <label for = "adults">Classic Plus:</label>
                        <input type = "number" id = "double" name="double" step = "1" min="0" max="<?php echo $userSeatsCount->getDoubleSeatCount() ?>" value="<?php echo $userSeatsCount->getDoubleSeatCount() ?>">
                    </div>
                </div>

                <div class="button">
                    <button type="submit" name="payment">Proceed to Payment</button>
                </div>
            </form>
        </div>
    </body>
</html>