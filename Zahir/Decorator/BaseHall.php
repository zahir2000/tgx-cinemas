<?php
require_once 'HallInterface.php';
/**
 * Description of Hall
 *
 * @author Zahir
 */
class BaseHall implements HallInterface {

    private $price;
    private $experience = "Unknown Experience";
    
    function __construct($price) {
        $this->price = $price;
    }
    
    public function experience(){
        return $this->experience;
    }

    public function cost() {
        return $this->price;
    }
}
