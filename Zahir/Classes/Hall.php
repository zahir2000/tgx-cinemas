<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/HallInterface.php';

/**
 * @author Zahiriddin Rustamov
 */
class Hall implements HallInterface {

    private $basePrice;
    private $experience = "TGX Experience:";

    function __construct($basePrice, $experience="") {
        $this->basePrice = $basePrice;
        $this->experience = $experience;
    }

    public function experience() {
        return $this->experience;
    }

    public function cost() {
        return $this->basePrice;
    }

}
