<?php

require_once 'HallDecorator.php';

/**
 * Description of LuxeDecorator
 *
 * @author Zahir
 */
class LuxeDecorator extends HallDecorator {

    public function __construct($hall) {
        parent::__construct($hall);
    }

    public function cost() {
        return $this->hall->cost() + 15;
    }

    public function experience() {
        return "Luxe";
    }

}
