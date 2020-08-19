<?php

require_once 'Decorator/HallInterface.php';

/**
 * Description of Hall
 *
 * @author Zahir
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
