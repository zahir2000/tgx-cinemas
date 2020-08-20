<?php
require_once 'Session/CheckLogin.php';
require_once 'Session/SessionHelper.php';
$token = SessionHelper::generateToken('seatcount_payment');

require_once 'ShowtimeXSLT.php';
require_once 'ShowtimeXPath.php';

require_once 'SelectedSeats/SelectedSeatsXML.php';
require_once 'SelectedSeats/SelectedSeatsXPath.php';

require_once 'Booking/BookingXML.php';

require_once 'Classes/Booking.php';
require_once 'Classes/User.php';

if (!filter_input(INPUT_GET, 'id')) {
    header('Location:/Assignment/Simran/Home.php');
}

include_once 'Header.php';

$showtimeId = filter_input(INPUT_GET, 'id');
$userId = SessionHelper::get('userId');

$userSeats = new SelectedSeatsXML($userId);
$userSeatsCount = new SelectedSeatsXPath($userId);

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
        <link rel="stylesheet" type="text/css" href="SeatCount.css"/>
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
                        <input type = "number" id = "adults" name="adults" step = "1" min="1" max="<?php echo $userSeatsCount->getRegularSeatCount() ?>" value="<?php echo $userSeatsCount->getRegularSeatCount() ?>">
                    </div>

                    <div>
                        <label for = "kids">Kids:</label>
                        <input type = "number" id= "kids" name="kids" step = "1" min="0" value="0" max="<?php echo ($userSeatsCount->getRegularSeatCount() - 1) ?>">
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
                    <button type="submit" id="payment" name="payment">Proceed to Payment</button>
                </div>
                <input type="hidden" value="<?php echo $token ?>" id='csrf_token' name='csrf_token'/>
            </form>
        </div>
    </body>

    <script>
        var total = <?php echo $userSeatsCount->getRegularSeatCount() ?>;
        function Adults_ValueChanged(element) {
            //document.getElementById("kids").max = total - element.value;
        }

        function Kids_ValueChanged(element) {
            //document.getElementById("adults").max = total - element.value;
        }

        $('document').ready(function () {
            var doubleSeatCount = <?php echo $userSeatsCount->getDoubleSeatCount() ?>;
            if (doubleSeatCount > 0) {
                document.getElementById("doubleSeat").style.display = "block";
            }

            let adultValue = $('#adults').val();
            let kidValue = $('#kids').val();

            $('#adults').on('change', function () {
                if ($(this).val() > adultValue) {
                    adultValue = $(this).val();
                    kidValue--;
                    document.getElementById("kids").value = kidValue;
                } else {
                    adultValue = $(this).val();
                    kidValue++;
                    document.getElementById("kids").value = kidValue;
                }

                value = $(this).val();
            });

            $('#kids').on('change', function () {
                if ($(this).val() > kidValue) {
                    kidValue = $(this).val();

                    adultValue--;
                    document.getElementById("adults").value = adultValue;

                } else {
                    kidValue = $(this).val();
                    adultValue++;
                    document.getElementById("adults").value = adultValue;
                }

                value = $(this).val();
            });

            if (total > 0) {
                document.getElementById("regularSeat").style.display = "block";
            }
        });
    </script>
</html>