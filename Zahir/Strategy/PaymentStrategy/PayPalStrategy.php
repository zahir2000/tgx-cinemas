<?php

require_once 'PaymentStrategy.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/UserConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Classes/User.php';

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

    public function pay($userId) {
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
