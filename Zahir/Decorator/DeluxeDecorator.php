<?php

require_once 'HallDecorator.php';

/**
 * Description of DeluxeDecorator
 *
 * @author Zahir
 */
class DeluxeDecorator extends HallDecorator {

    public function __construct($hall) {
        parent::__construct($hall);
    }

    public function cost() {
        return $this->hall->cost() + 10;
    }

    public function experience() {
        return "Deluxe";
    }

}
