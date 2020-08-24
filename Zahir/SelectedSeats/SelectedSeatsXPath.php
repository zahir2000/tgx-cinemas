<?php

/**
 * @author Zahiriddin Rustamov
 */
class SelectedSeatsXPath {

    private $xpath;

    public function __construct($userId) {
        $doc = new DOMDocument();
        $doc->load('SelectedSeats/SelectedSeats' . $userId . '.xml');
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
