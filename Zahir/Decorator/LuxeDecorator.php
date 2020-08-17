<?php

require_once 'HallDecorator.php';
require_once 'TIME_OF_DAY.php';

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
        $cost = $this->hall->cost();

        if ($this->hall->getTimeOfDay() == TIME_OF_DAY::MORNING) {
            $cost -= 5;
        } else if ($this->hall->getTimeOfDay() == TIME_OF_DAY::AFTERNOON) {
            $cost += 10;
        } else if ($this->hall->getTimeOfDay() == TIME_OF_DAY::EVENING) {
            $cost += 20;
        }

        return $cost;
    }

    public function experience() {
        return $this->hall->experience() . " Luxe";
    }

}
