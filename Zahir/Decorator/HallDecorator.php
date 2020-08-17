<?php

require_once 'HallInterface.php';

/**
 * Description of HallDecorator
 *
 * @author Zahir
 */
abstract class HallDecorator implements HallInterface {

    protected $hall;

    public function __construct($hall) {
        $this->hall = $hall;
    }

    public abstract function cost();

    public abstract function experience();

    public function getTimeOfDay() {
        return $this->hall->getTimeOfDay();
    }

}
