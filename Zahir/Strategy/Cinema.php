<?php

/**
 * Description of Cinema
 *
 * @author Zahir
 */
class Cinema {

    private $name;
    private $location;

    function __construct($name = "", $location = "") {
        $this->name = $name;
        $this->location = $location;
    }

    function getName() {
        return $this->name;
    }

    function getLocation() {
        return $this->location;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setLocation($location): void {
        $this->location = $location;
    }

}
