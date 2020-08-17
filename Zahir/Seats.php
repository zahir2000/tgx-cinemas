<?php

require_once '../Database/BookingConnection.php';
require_once 'ShowtimeXML.php';
require_once 'SeatXSLT.php';
require_once 'ShowtimeXSLT.php';

session_start();
if(isset($_SESSION['selectedSeats'])){
    unset($_SESSION['selectedSeats']);
}

if (isset($_GET['id'])) {
    $db = new BookingConnection();
    $showtimeId = $_GET['id'];
    $showtimeDetails = $db->getShowTimeDetails($showtimeId);

    $xmlGenMovie = new ShowtimeXML($showtimeDetails);
    $xmlGenShowtime = new ShowtimeXSLT($showtimeId);
    $xmlGenSeat = new SeatXSLT($showtimeId);
}
?>

