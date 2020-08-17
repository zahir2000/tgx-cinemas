<?php

/**
 * Description of Ticket
 *
 * @author Zahir
 */
class Ticket {

    private $price;
    private $type;

    function __construct($price, $type) {
        $this->price = $price;
        $this->type = $type;
    }

    function getPrice() {
        return $this->price;
    }

    function getType() {
        return $this->type;
    }

    function setPrice($price): void {
        $this->price = $price;
    }

    function setType($type): void {
        $this->type = $type;
    }
    
    public function cost(){
        return $this->type->cost($this->price);
    }

}
