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

    public function pay($amount) {
        echo "$amount paid using PayPal.";
    }

}
