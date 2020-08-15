<?php

session_start();

if (isset($_POST['seatId'])) {
    $uid = $_POST['seatId'];
    $action = $_POST['action'];
    $seatType = $_POST['seatType'];

    if (!isset($_SESSION["selectedSeats"])) {
        $_SESSION["selectedSeats"] = array();
    }

    if ($action == 'add') {
        $array = $_SESSION['selectedSeats'];

        if (!in_array($uid, $array)) {
            $array[] = $uid . $seatType;
            $_SESSION["selectedSeats"] = $array;
        }
    } else if ($action == 'remove') {
        $array = $_SESSION['selectedSeats'];

        if (($key = array_search($uid, $array)) !== false) {
            array_splice($array, $key, 1);
        }

        $_SESSION["selectedSeats"] = $array;
    }
}