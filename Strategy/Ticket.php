<?php

/**
 * Description of Ticket
 *
 * @author Zahir
 */
class Ticket {

    private $price;
    private $type;
    private $seat;

    function __construct($price, $type, $seat="") {
        $this->price = $price;
        $this->type = $type;
        $this->seat = $seat;
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
    
    function getSeat() {
        return $this->seat;
    }

    function setSeat($seat): void {
        $this->seat = $seat;
    }
  
    public function cost(){
        return $this->type->cost($this->price);
    }

}
