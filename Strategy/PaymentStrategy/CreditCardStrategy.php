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
   
    public function pay($amount) {
        //Store to Database
    }

}
