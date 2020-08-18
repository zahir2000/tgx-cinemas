<?php

/**
 *
 * @author Zahir
 */
interface SeatPriceStrategy {
    
    public function type();

    public function cost($price);
}
