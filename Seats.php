<?php

require_once '../Database/BookingConnection.php';
require_once 'ShowtimeXML.php';
require_once 'SeatXSLT.php';
require_once 'ShowtimeXSLT.php';
require_once 'Booking/User.php';
require_once 'Booking/Booking.php';

session_start();

if (isset($_SESSION['selectedSeats'])) {
    unset($_SESSION['selectedSeats']);
}

if (isset($_GET['id'])) {
    $db = new BookingConnection();
    $showtimeId = $_GET['id'];
    $showtimeDetails = $db->getShowTimeDetails($showtimeId);

    $xmlGenMovie = new ShowtimeXML($showtimeDetails);
    $xmlGenShowtime = new ShowtimeXSLT($showtimeId);
    $xmlGenSeat = new SeatXSLT($showtimeId);

    $user = new User("1", "Zahir Sher", "zakisher@gmail.com", "0108003610", "24/01/2000", "Male", "C-4-1, Idaman Putera", "zahir", "123");
    $booking = new Booking();
    $booking->setUser($user);
}
?>

