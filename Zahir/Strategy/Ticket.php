<?php

/**
 * Description of Ticket
 *
 * @author Zahir
 */
class Ticket {

    private $price;
    private $type;

    function __construct($price = "", $type = "") {
        $this->price = $price;
        $this->type = $type;
    }

}
