<?php

/**
 * @author Zahiriddin Rustamov
 */
interface SeatPriceStrategy {
    
    public function type();

    public function cost($price);
}
