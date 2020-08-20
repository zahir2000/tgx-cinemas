<?php

require_once 'SessionHelper.php';

if (isset($_POST['seatId'])) {
    $uid = $_POST['seatId'];
    $action = $_POST['action'];
    $seatType = $_POST['seatType'];

    if (!SessionHelper::check('selectedSeats')) {
        SessionHelper::add('selectedSeats', array());
    }
    
    $array = SessionHelper::get('selectedSeats');

    if ($action == 'add') {
        if (!in_array($uid.$seatType, $array)) {
            $array[] = $uid . $seatType;
            SessionHelper::add('selectedSeats', $array);
        }
    } else if ($action == 'remove') {
        if (($key = array_search($uid.$seatType, $array)) !== false) {
            array_splice($array, $key, 1);
        }

        SessionHelper::add('selectedSeats', $array);
    }
}