<?php
/**
 * @author Zahiriddin Rustamov
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';

require_once '../Database/DatabaseConnection.php';
require_once '../Database/BookingConnection.php';

require_once 'Classes/User.php';
require_once 'Classes/Booking.php';
require_once 'Classes/Cart.php';
require_once 'Classes/Ticket.php';

require_once 'Strategy/SeatPriceStrategy/RegularSeatStrategy.php';
require_once 'Strategy/SeatPriceStrategy/TwinSeatStrategy.php';

include_once 'Header.php';

if (!filter_input(INPUT_GET, 'id')) {
    header('Location:/tgx-cinemas/Home.php');
}

$movieId = filter_input(INPUT_GET, 'id');

date_default_timezone_set('Asia/Kuala_Lumpur');

if (filter_input(INPUT_GET, 'date')) {
    $date = filter_input(INPUT_GET, 'date');

    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);

    if (!checkdate($month, $day, $year)) {
        header('Location:/tgx-cinemas/Home.php');
    }
} else {
    $date = date("Y-m-d");
}

$db = DatabaseConnection::getInstance();
$con = BookingConnection::getInstance();
$result = $con->getMovieDetails($movieId);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - <?php echo $result['name'] ?></title>
        <link rel="stylesheet" href="/tgx-cinemas/Zahir/css/Movies.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous">
    </head>
    <body>
        <div class="booking-panel">

            <div class="booking-panel-section booking-panel-title">
                <h1>RESERVE YOUR TICKET</h1>
            </div>
            <div class="booking-panel-section booking-panel-close" onclick="window.history.go(-1); return false;">
                <i class="fas fa-2x fa-times"></i>
            </div>

            <div class="booking-panel-section booking-panel-poster">
                <div class="movie-box">
                    <?php echo '<img src="../' . $result['poster'] . '" alt="">'; ?>
                </div>
            </div>

            <div class="booking-panel-section booking-panel-details">
                <div class="title"><?php
                    echo $result['name'];
                    echo " (" . $result['ageRestriction'] . ")";
                    ?></div>
                <div class="movie-information">
                    <table>
                        <tr>
                            <td>Genre</td>
                            <td><?php echo $result['genre']; ?></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><?php echo $result['length'] . " minutes"; ?></td>
                        </tr>
                        <tr>
                            <td>Language</td>
                            <td><?php echo $result['language']; ?></td>
                        </tr>
                        <tr>
                            <td>Subtitle</td>
                            <td><?php echo $result['subtitle']; ?></td>
                        </tr>
                        <tr>
                            <td>Release Date</td>
                            <td><?php echo $newDate = date("d F Y", strtotime($result['releaseDate'])); ?></td>
                        </tr>
                        <tr>
                            <td>Actors</td>
                            <td><?php echo $result['cast']; ?></td>
                        </tr>
                        <tr>
                            <td>Director</td>
                            <td><?php echo $result['director']; ?></td>
                        </tr>
                        <tr>
                            <td>Distributor</td>
                            <td><?php echo $result['distributor']; ?></td>
                        </tr>
                        <tr>
                            <td>Synopsis</td>
                            <td><?php echo $result['synopsis']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        <div class="booking-panel-form">
            <?php
            $movieDates = $con->getShowDates($movieId);

            foreach ($movieDates as $d) {
                if ($d['showDate'] == $date) {
                    echo "<a class='movie-dates movie-dates-active' href='Movies.php?id=$movieId&date=" . $d['showDate'] . "'>" . date('d F Y', strtotime($d['showDate'])) . "</a>";
                } else {
                    echo "<a class='movie-dates' href='Movies.php?id=$movieId&date=" . $d['showDate'] . "'>" . date('d F Y', strtotime($d['showDate'])) . "</a>";
                }
            }
            ?>
        </div>

        <div class="booking-panel-form" style="margin-bottom: 5vh">
            <div style="margin: auto;  width: 80%; padding-top: 2vh; padding-bottom:2vh"><h2 style="margin-top:0">SHOWTIMES</h2>
                <?php
                $cinemas = $con->getShowCinemas($movieId, $date);
                
                if (isset($cinemas) && count($cinemas) > 0) {
                    foreach ($cinemas as $c) {
                        echo "<button class='accordion'>";
                        echo $c['name'];
                        echo "</button><div class='panel'>";

                        $experience = $con->getShowExperiences($movieId, $date, $c['cinemaID']);

                        foreach ($experience as $e) {
                            echo "<h4>" . $e['experience'] . "</h4>";

                            $showtimes = $con->getShowTime($movieId, $date, $c['cinemaID'], $e['experience']);

                            foreach ($showtimes as $t) {
                                $showTimeInput = $t['showTime'];
                                $showTimeHour = (int) ($showTimeInput / 60);
                                $showTimeMin = str_pad($showTimeInput % 60, 2, '0', STR_PAD_RIGHT);

                                if (SessionHelper::check('userId')) {
                                    echo "<a class='movie-times' href='Seats.php?id=" . $t['showtimeID'] . "'>" . $showTimeHour . ":" . $showTimeMin . "</a>";
                                } else {
                                    echo "<a class='movie-times' disabled='true' onclick='toast()'>" . $showTimeHour . ":" . $showTimeMin . "</a>";
                                }
                            }
                        }

                        echo "</div>";
                    }
                } else {
                    $cinemas = NULL;
                    echo "<h3 style='margin-bottom:0'>No showtimes found for $date</h3>";
                }
                ?>

            </div>
        </div>

        <div id="snackbar">Please login before making booking.</div>

        <script>
            function toast() {
                // Get the snackbar DIV
                var x = document.getElementById("snackbar");

                // Add the "show" class to DIV
                x.className = "show";

                // After 3 seconds, remove the show class from DIV
                setTimeout(function () {
                    x.className = x.className.replace("show", "");
                }, 3000);
            }
        </script>
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