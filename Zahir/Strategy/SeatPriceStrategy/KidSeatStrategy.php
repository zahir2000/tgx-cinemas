<?php

require_once 'SeatPriceStrategy.php';

/**
 * @author Zahiriddin Rustamov
 */
class KidSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price -= 5;
    }

    public function type() {
        return "Regular";
    } 

}
