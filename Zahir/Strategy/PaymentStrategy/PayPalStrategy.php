<?php

require_once 'PaymentStrategy.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Database/BookingConnection.php';

/**
 * Description of PayPalStrategy
 *
 * @author Zahir
 */
class PayPalStrategy implements PaymentStrategy {

    private $email;
    private $password;

    function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    function getEmail() {
        return $this->email;
    }

    public function pay($userId, $cart) {
        //Store to Database
        //Delete Booking1.xml and UserSeats1.xml

        $user = new User(1, "Zahir Sher", "zakisher@gmail.com", "0108003610", "24/01/2000", "Male", "C-4-1, Idaman Putera", "zahir", "123");

        $bookingDOM = new BookingDOMParser($userId);
        $booking = $bookingDOM->retrieveBookingDetails();
        $booking->setUser($user);
        
        $storeToDb = BookingConnection::getInstance();
        $storeToDb->storeToDatabase($booking, $cart);
    }

}
