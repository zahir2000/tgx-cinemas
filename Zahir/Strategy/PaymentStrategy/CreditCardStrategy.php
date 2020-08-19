<?php

require_once 'PaymentStrategy.php';

/**
 * Description of CreditCardStrategy
 *
 * @author Zahir
 */
class CreditCardStrategy implements PaymentStrategy {

    private $name;
    private $number;
    private $cvv;
    private $expiryMonth;
    private $expiryYear;
    
    function __construct($name, $number, $cvv, $expiryMonth, $expiryYear) {
        $this->name = $name;
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expiryMonth = $expiryMonth;
        $this->expiryYear = $expiryYear;
    }
    
    function getName() {
        return $this->name;
    }
   
    public function pay($userId, $cart) {
        //Store to Database
        //Delete Booking1.xml and UserSeats1.xml

        $user = new User(1, "Zahir Sher", "zakisher@gmail.com", "0108003610", "24/01/2000", "Male", "C-4-1, Idaman Putera", "zahir", "123");

        $bookingDOM = new BookingDOMParser($userId);
        $booking = $bookingDOM->retrieveBookingDetails();
        $booking->setUser($user);
        
        $storeToDb = new BookingConnection();
        $storeToDb->storeToDatabase($booking, $cart);
    }

}
