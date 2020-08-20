<?php

require_once '../Database/BookingConnection.php';
require_once 'ShowtimeXML.php';
require_once 'SeatsXSLT.php';
require_once 'ShowtimeXSLT.php';

require_once 'Session/CheckLogin.php';
require_once 'Session/SessionHelper.php';

if(!filter_input(INPUT_GET, 'id')){
    header('Location:/Assignment/Simran/Home.php');
}

include_once 'Header.php';

SessionHelper::remove('selectedSeats');
SessionHelper::remove('user_cart');

$db = new BookingConnection();
$showtimeId = filter_input(INPUT_GET, 'id');
$showtimeDetails = $db->getShowTimeDetails($showtimeId);

$xmlGenMovie = new ShowtimeXML($showtimeDetails);
$xmlGenShowtime = new ShowtimeXSLT($showtimeId);
$xmlGenSeat = new SeatsXSLT($showtimeId);