<?php

/**
 * CinemaXPath is used to navigate through attributes of the Cinema.Xml file
 *
 * @author Jaloliddin
 */
class CinemaXPath {

    private $xpath;

    public function __construct($filename) {
        $doc = new DOMDocument();
        $doc->load($filename);
        $this->xpath = new DOMXPath($doc);
    }

    public function checkID($cinemaID) {
        $expr = ('//cinema[@id=' . $cinemaID . ']');
        $exists = $this->xpath->query($expr);

        if ($exists->length > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getDetailsById($cinemaID) {
        $expr = ('/cinemas/cinema[@id=' . $cinemaID . ']');
        $result = $this->xpath->query($expr);

        foreach ($result as $item) {
            echo $item->nodeValue . "<br />";

            foreach ($item->getElementsByTagName('date') as $a) {
                echo $a->nodeValue;
            }
        }
    }

}
