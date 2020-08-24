<?php

require_once 'SeatPriceStrategy.php';

/**
 * @author Zahiriddin Rustamov
 */
class TwinSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price += 10;
    }

    public function type() {
        return "Double";
    }

}
