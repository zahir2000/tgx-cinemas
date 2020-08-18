<?php

require_once 'HallDecorator.php';
require_once 'TIME_OF_DAY.php';

/**
 * Description of DeluxeDecorator
 *
 * @author Zahir
 */
class DeluxeDecorator extends HallDecorator {

    public function __construct($hall, $timeOfDay) {
        parent::__construct($hall, $timeOfDay);
    }

    public function cost() {
        $cost = $this->hall->cost();

        if ($this->getTimeOfDay() == TIME_OF_DAY::MORNING) {
            $cost -= 5;
        } else if ($this->getTimeOfDay() == TIME_OF_DAY::AFTERNOON) {
            $cost += 5;
        } else if ($this->getTimeOfDay() == TIME_OF_DAY::EVENING) {
            $cost += 10;
        }
        
        return $cost;
    }

    public function experience() {
        return $this->hall->experience() . " Deluxe";
    }

}
