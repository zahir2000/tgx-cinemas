<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/HallDecorator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Utility/DayTime.php';

/**
 * @author Zahiriddin Rustamov
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
