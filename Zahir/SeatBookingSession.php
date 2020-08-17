<?php

session_start();

if (isset($_POST['seatId'])) {
    $uid = $_POST['seatId'];
    $action = $_POST['action'];
    $seatType = $_POST['seatType'];

    if (!isset($_SESSION["selectedSeats"])) {
        $_SESSION["selectedSeats"] = array();
    }
    
    $array = $_SESSION['selectedSeats'];

    if ($action == 'add') {
        if (!in_array($uid.$seatType, $array)) {
            $array[] = $uid . $seatType;
            $_SESSION["selectedSeats"] = $array;
        }
    } else if ($action == 'remove') {
        if (($key = array_search($uid.$seatType, $array)) !== false) {
            array_splice($array, $key, 1);
        }

        $_SESSION["selectedSeats"] = $array;
    }
}