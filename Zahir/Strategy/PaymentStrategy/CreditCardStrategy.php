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
    private $expiryDate;
    
    function __construct($name, $number, $cvv, $expiryDate) {
        $this->name = $name;
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expiryDate = $expiryDate;
    }
    
    function getName() {
        return $this->name;
    }
   
    public function pay($amount) {
        //Store to Database
    }

}
