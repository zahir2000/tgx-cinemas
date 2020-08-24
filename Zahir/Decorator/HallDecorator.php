<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/HallInterface.php';

/**
 * @author Zahiriddin Rustamov
 */
abstract class HallDecorator implements HallInterface {

    protected $hall;
    private $timeOfDay;

    public function __construct($hall, $timeOfDay) {
        $this->hall = $hall;
        $this->timeOfDay = $timeOfDay;
    }
    
    protected function getTimeOfDay() {
        return $this->timeOfDay;
    }

    public abstract function cost();

    public abstract function experience();

}
