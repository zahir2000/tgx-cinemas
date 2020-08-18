<?php

require_once 'HallInterface.php';

/**
 * Description of HallDecorator
 *
 * @author Zahir
 */
abstract class HallDecorator implements HallInterface {

    protected $hall;
    private $timeOfDay;

    public function __construct($hall, $timeOfDay) {
        $this->hall = $hall;
        $this->timeOfDay = $timeOfDay;
    }
    
    function getTimeOfDay() {
        return $this->timeOfDay;
    }

    public abstract function cost();

    public abstract function experience();

}
