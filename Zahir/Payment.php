<?php

session_start();

if (isset($_SESSION['selectedSeats'])) {
    $array = $_SESSION['selectedSeats'];

    for ($x = 0, $max = count($array); $x < $max; ++$x) {
        echo $array[$x];
    }
}
