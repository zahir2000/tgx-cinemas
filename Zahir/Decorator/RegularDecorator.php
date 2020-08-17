<?php

/**
 * Description of RegularDecorator
 *
 * @author Zahir
 */
class RegularDecorator extends HallDecorator {

    public function __construct($hall) {
        parent::__construct($hall);
    }

    public function cost() {
        return $this->hall->cost() + 5;
    }

    public function experience() {
        return "Regular";
    }

}
