<?php

require_once 'SeatPriceStrategy.php';

/**
 * Description of RegularSeatStrategy
 *
 * @author Zahir
 */
class RegularSeatStrategy implements SeatPriceStrategy {

    public function cost($price) {
        return $price;
    }

}
