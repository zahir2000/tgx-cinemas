<?php

/**
 * Description of ShowtimeXPath
 *
 * @author Zahir
 */
class ShowtimeXPath {

    private $xpath;

    public function __construct($filename) {
        $doc = new DOMDocument();
        $doc->load($filename);
        $this->xpath = new DOMXPath($doc);
    }

    public function checkId($showtimeID) {
        $expr = ('/showtimes/showtime[@id=' . $showtimeID . ']');
        $exists = $this->xpath->query($expr);

        if ($exists->length > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getHallType($showtimeId) {
        $expr = ('/showtimes/showtime[@id=' . $showtimeId . ']/cinema/hall');
        $exists = $this->xpath->query($expr);

        if ($exists->length > 0) {
            foreach ($exists as $hallType) {
                return $hallType->nodeValue;
            }
        }
        
        return "";
    }

    public function getDetailsById($showtimeID) {
        $expr = ('/showtimes/showtime[@id=' . $showtimeID . ']');
        $result = $this->xpath->query($expr);

        foreach ($result as $item) {
            echo $item->nodeValue . "<br />";

            foreach ($item->getElementsByTagName('date') as $a) {
                echo $a->nodeValue;
            }
        }
    }

}
