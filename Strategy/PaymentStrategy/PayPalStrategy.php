<?php

require_once 'PaymentStrategy.php';

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

    public function pay($amount) {
        //Store to Database
        //Delete Booking1.xml and UserSeats1.xml
    }

}
