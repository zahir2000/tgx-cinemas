<?php

require_once 'CinemaXPath.php';

/**
 * Description of CinemaXML
 *
 * @author Jaloliddin
 */
class CinemaXML {

    private $file = "Cinema.xml";

    function __construct($cinemaDetails) {
        $this->createXML();
        $this->append($cinemaDetails);
    }

    private function append($cinemaDetails) {
        $xpath = new CinemaXPath($this->file);

        foreach ($cinemaDetails as $cinema) {
            $this->createElement($cinema);
        }
    }

    private function createElement($cinema) {
        //
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents($this->file), LIBXML_NOBLANKS);
        $root = $domtree->getElementsByTagName('cinemas')->item(0);



        //
        $xmlCinemas = $domtree->createElement("cinemas");
        $xmlCinemas = $root->appendChild($xmlCinemas);

        //



        $xmlCinemas->appendChild($xmlCinema = $domtree->createElement('cinema'));

        //
        $xmlCinema->appendChild($domtree->createAttribute('id'));
        $xmlCinema->setAttribute('id', $cinema['cinemaID']);
        $xmlCinema->appendChild($domtree->createElement('name', $cinema['name']));
        $xmlCinema->appendChild($domtree->createElement('location', $cinema['location']));


        //
        $domtree->save($this->file);
    }

    private function createXML() {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;

        $xmlCinemas = $domtree->createElement("cinemas");
        $xmlCinemas = $domtree->appendChild($xmlCinemas);
        $domtree->save($this->file);
    }

    private function readFromXML($file) {
        $xml = @file_get_contents($file);

        if (trim($xml) == '') {
            $this->createXML();
        }
    }

}
