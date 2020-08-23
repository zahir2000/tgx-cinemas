<?php

require_once 'PaymentStrategy.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/UserConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Classes/User.php';

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

        $userCon = UserConnection::getInstance();
        $result = $userCon->getUserDetails(SessionHelper::get('userId'));
        $user = new User(SessionHelper::get('userId'), $result['name'], $result['email'], $result['number'], $result['dob'], $result['gender'], $result['address']);

        $bookingDOM = new BookingDOMParser($userId);
        $booking = $bookingDOM->retrieveBookingDetails();
        $booking->setUser($user);

        $storeToDb = BookingConnection::getInstance();
        $storeToDb->storeToDatabase($booking, $cart);
    }

}
