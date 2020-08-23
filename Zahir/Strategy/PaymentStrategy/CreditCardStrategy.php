<?php

require_once 'PaymentStrategy.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';

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

    public function pay($userId) {
        //TODO: Get user from database.

        if (SessionHelper::check('user_cart')) {
            $cartLocation = SessionHelper::get('user_cart');
        }

        $a = file_get_contents("Cart/" . $cartLocation);
        $cart = unserialize($a);

        $user = new User(1, "Zahir Sher", "zakisher@gmail.com", "0108003610", "24/01/2000", "Male", "C-4-1, Idaman Putera", "zahir", "123");

        $bookingDOM = new BookingDOMParser($userId);
        $booking = $bookingDOM->retrieveBookingDetails();
        $booking->setUser($user);

        $storeToDb = BookingConnection::getInstance();
        $storeToDb->storeToDatabase($booking, $cart);
    }

}
