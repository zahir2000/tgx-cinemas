<?php

require_once 'SeatPriceStrategy.php';

/**
 * Description of TwinSeatStrategy
 *
 * @author Zahir
 */
class TwinSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price += 10;
    }

    public function type() {
        return "Twin Seat";
    }

}
