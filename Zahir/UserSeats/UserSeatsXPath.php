<?php

/**
 * Description of UserSeatsXPath
 *
 * @author Zahir
 */
class UserSeatsXPath {

    private $xpath;

    public function __construct($filename) {
        $doc = new DOMDocument();
        $doc->load($filename);
        $this->xpath = new DOMXPath($doc);
    }

    public function getRegularSeatCount() {
        $expr = ("count(//seat[type='Regular'])");
        $count = $this->xpath->evaluate($expr);
        return $count;
    }

    public function getDoubleSeatCount() {
        $expr = ("count(//seat[type='Double'])");
        $count = $this->xpath->evaluate($expr);
        return $count;
    }

}
