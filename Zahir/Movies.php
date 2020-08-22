<?php
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
    header('Location:/Assignment/Home.php');
}

$id = filter_input(INPUT_GET, 'id');

date_default_timezone_set('Asia/Kuala_Lumpur');

if (filter_input(INPUT_GET, 'date')) {
    $date = filter_input(INPUT_GET, 'date');

    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);

    if (!checkdate($month, $day, $year)) {
        header('Location:/Assignment/Home.php');
    }
} else {
    $date = date("Y-m-d");
}

$db = DatabaseConnection::getInstance();
$bookingDb = new BookingConnection();
$result = $bookingDb->getMovieDetails($id);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - <?php echo $result['name'] ?></title>
        <link rel="stylesheet" href="Movies.css">
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
            $queryDate = "SELECT DISTINCT showDate FROM showtime WHERE movieid = ? ORDER BY showDate";
            //$queryDate = "SELECT DISTINCT showDate FROM showtime WHERE movieid = ? AND showDate >= CURDATE() ORDER BY showDate";
            $stmtDate = $db->getDb()->prepare($queryDate);
            $stmtDate->bindParam(1, $id, PDO::PARAM_INT);
            $stmtDate->execute();

            if ($stmtDate->rowCount() != 0) {
                $movieDates = $stmtDate->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $movieDates = NULL;
            }

            foreach ($movieDates as $d) {
                if ($d['showDate'] == $date) {
                    echo "<a class='movie-dates movie-dates-active' href='Movies.php?id=$id&date=" . $d['showDate'] . "'>" . $d['showDate'] . "</a>";
                } else {
                    echo "<a class='movie-dates' href='Movies.php?id=$id&date=" . $d['showDate'] . "'>" . $d['showDate'] . "</a>";
                }
            }
            ?>
        </div>

        <div class="booking-panel-form" style="margin-bottom: 5vh">

            <?php
            /*$query = "SELECT * FROM showtime WHERE movieid = ?";
            $stmt = $db->getDb()->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() != 0) {
                $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $showtimes = NULL;
            }*/

            $cinemaQuery = "SELECT DISTINCT C.cinemaID, C.name "
                    . "FROM showtime S, hall H, cinema C "
                    . "WHERE movieid = ? AND showDate = ? AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID";

            $cinemaStmt = $db->getDb()->prepare($cinemaQuery);
            $cinemaStmt->bindParam(1, $id, PDO::PARAM_INT);
            $cinemaStmt->bindParam(2, $date);
            $cinemaStmt->execute();
            ?>

            <div style="margin: auto;  width: 80%; padding-top: 2vh; padding-bottom:2vh"><h2 style="margin-top:0">SHOWTIMES</h2>
                <?php
                if ($cinemaStmt->rowCount() != 0) {
                    $cinemas = $cinemaStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($cinemas as $c) {
                        echo "<button class='accordion'>";
                        echo $c['name'];
                        echo "</button><div class='panel'>";

                        $expQuery = "SELECT DISTINCT experience "
                                . "FROM showtime S, hall H, cinema C "
                                . "WHERE movieid = ? AND showDate = ? AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID AND C.cinemaID = ?";

                        $expStmt = $db->getDb()->prepare($expQuery);
                        $expStmt->bindParam(1, $id, PDO::PARAM_INT);
                        $expStmt->bindParam(2, $date);
                        $expStmt->bindParam(3, $c['cinemaID'], PDO::PARAM_INT);
                        $expStmt->execute();

                        if ($expStmt->rowCount() != 0) {
                            $experience = $expStmt->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            $experience = NULL;
                        }

                        foreach ($experience as $e) {
                            echo "<h4>" . $e['experience'] . "</h4>";

                            $timeQuery = "SELECT showTime, showtimeID "
                                    . "FROM showtime S, hall H, cinema C "
                                    . "WHERE movieid = ? AND showDate = ? AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID AND C.cinemaID = ?";

                            $timeStmt = $db->getDb()->prepare($timeQuery);
                            $timeStmt->bindParam(1, $id, PDO::PARAM_INT);
                            $timeStmt->bindParam(2, $date);
                            $timeStmt->bindParam(3, $c['cinemaID'], PDO::PARAM_INT);
                            $timeStmt->execute();

                            //str_pad("1234567", 8, '0', STR_PAD_LEFT);

                            foreach ($timeStmt as $t) {
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