<?php
/**
 * @author Zahiriddin Rustamov
 */
require_once 'Session/SessionHelper.php';

if (isset($_GET['confirm'])) {
    SessionHelper::remove('selectedSeats');
    SessionHelper::remove('user_cart');
    SessionHelper::removeToken('seatcount_payment');
    SessionHelper::removeToken('receipt');

    header('Location:/tgx-cinemas/Home.php?booking=expired');
}

if (SessionHelper::check('booking_timer')) {
    $bookingTimeLeft = time() - SessionHelper::get('booking_timer');
} else {
    $bookingTimeLeft = 60 * 10;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
        <style>
            *{
                font-family: "Verdana", sans-serif;
            }

            .timer-panel {
                background-color: #000;
                padding: 40px;
                box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -webkit-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -moz-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                transition: all 0.7s ease;
                width: 90%;
                /* height: 100vh; */
                margin: 0 auto;
                margin-top: 3vh;
                color: #fff;
            }
        </style>
    </head>

    <div class="timer-panel">
        <label>
            <center>
                <b>TIME LEFT: <label id="minute"></label>:<label id="second"></label></b>
            </center>
        </label>
    </div>


    <script type="text/javascript">
        function BookingWatcher() {
            var secondsSinceLastActivity = 0;
            var maxInactivity = <?php echo (600 - $bookingTimeLeft) ?>;
            document.getElementById("minute").innerHTML = pad(Math.floor(maxInactivity / 60), 2);
            document.getElementById("second").innerHTML = pad(Math.floor(maxInactivity % 60), 2);

            setInterval(function () {
                secondsSinceLastActivity++;
                document.getElementById("minute").innerHTML = pad(Math.floor((maxInactivity - secondsSinceLastActivity) / 60), 2);
                document.getElementById("second").innerHTML = pad((maxInactivity - secondsSinceLastActivity) % 60, 2);

                if (secondsSinceLastActivity >= maxInactivity) {
                    location.href = '/tgx-cinemas/Zahir/BookingTimer.php?confirm=yes';
                }
            }, 1000);
        }

        function pad(str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }

        window.onload = function () {
            BookingWatcher();
        };


    </script>
</html>
