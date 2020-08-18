<?php

require_once 'SeatPriceStrategy.php';

/**
 * Description of KidSeatStrategy
 *
 * @author Zahir
 */
class KidSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price -= 5;
    }

    public function type() {
        return "Kid Seat";
    } 

}
