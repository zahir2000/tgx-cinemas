<?php

require_once 'HallDecorator.php';
require_once 'Utility/DayTime.php';
/**
 * Description of RegularDecorator
 *
 * @author Zahir
 */
class RegularDecorator extends HallDecorator {

    public function __construct($hall, $timeOfDay) {
        parent::__construct($hall, $timeOfDay);
    }

    public function cost() {
        $cost = $this->hall->cost();

        if ($this->getTimeOfDay() == DayTime::MORNING) {
            $cost -= 5;
        } else if ($this->getTimeOfDay() == DayTime::AFTERNOON) {
            $cost += 5;
        } else if ($this->getTimeOfDay() == DayTime::EVENING) {
            $cost += 10;
        }
        
        return $cost;
    }

    public function experience() {
        return $this->hall->experience() . " Regular";
    }

}
