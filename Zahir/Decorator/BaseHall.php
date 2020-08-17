<?php

require_once 'HallInterface.php';
require_once 'TIME_OF_DAY.php';

/**
 * Description of Hall
 *
 * @author Zahir
 */
class BaseHall implements HallInterface {

    private $price;
    private $experience = "TGX Experience:";
    private $timeOfDay;

    function __construct($price, $timeOfDay) {
        $this->price = $price;
        $this->timeOfDay = $timeOfDay;
    }

    function getTimeOfDay() {
        return $this->timeOfDay;
    }

    function setTimeOfDay($timeOfDay): void {
        $this->timeOfDay = $timeOfDay;
    }

    public function experience() {
        return $this->experience;
    }

    public function cost() {
        return $this->price;
    }

}
