<?php

require_once 'SeatPriceStrategy.php';

/**
 * @author Zahiriddin Rustamov
 */
class RegularSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price;
    }

    public function type() {
        return "Regular";
    }

}
