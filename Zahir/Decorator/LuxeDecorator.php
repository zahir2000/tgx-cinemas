<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Zahir/Decorator/HallDecorator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Zahir/Utility/DayTime.php';

/**
 * Description of LuxeDecorator
 *
 * @author Zahir
 */
class LuxeDecorator extends HallDecorator {

    public function __construct($hall, $timeOfDay) {
        parent::__construct($hall, $timeOfDay);
    }

    public function cost() {
        $cost = $this->hall->cost();

        if ($this->getTimeOfDay() == DayTime::MORNING) {
            $cost -= 5;
        } else if ($this->getTimeOfDay() == DayTime::AFTERNOON) {
            $cost += 10;
        } else if ($this->getTimeOfDay() == DayTime::EVENING) {
            $cost += 20;
        }

        return $cost;
    }

    public function experience() {
        return $this->hall->experience() . " Luxe";
    }

}
