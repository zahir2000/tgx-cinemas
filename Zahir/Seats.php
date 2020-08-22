<?php

require_once '../Database/BookingConnection.php';
require_once 'ShowtimeXML.php';
require_once 'SeatsXSLT.php';
require_once 'ShowtimeXSLT.php';

require_once 'Session/CheckLogin.php';
require_once 'Session/SessionHelper.php';

if (!filter_input(INPUT_GET, 'id')) {
    header('Location:/Assignment/Home.php');
}

if (!isset($_GET['id'])) {
    exit(0);
}

include_once 'Header.php';
include_once 'BookingTimer.php';
?>

<title>TGX Cinemas - Seat Selection</title>

<?php
SessionHelper::remove('selectedSeats');
SessionHelper::remove('user_cart');

$db = new BookingConnection();
$showtimeId = filter_input(INPUT_GET, 'id');
$showtimeDetails = $db->getShowTimeDetails($showtimeId);

$xmlGenMovie = new ShowtimeXML($showtimeDetails);
$xmlGenShowtime = new ShowtimeXSLT($showtimeId);
$xmlGenSeat = new SeatsXSLT($showtimeId);