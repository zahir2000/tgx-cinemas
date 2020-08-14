<?php

require_once 'ShowtimeXPath.php';

/**
 * Description of BookingXMLBuilder
 *
 * @author Zahir
 */
class ShowtimeXMLBuilder {
    public function __construct() {
        $this->readFromXML("showtime.xml");
    }

    public function append($showtimeDetails) {
        $xpath = new ShowtimeXPath("showtime.xml");
        
        //$xpath->getDetailsById(1);

        if (!$xpath->checkId($showtimeDetails['showtimeID'])) {
            $this->createElement($showtimeDetails);
        }
    }

    private function createElement($showtimeDetails) {
        /* create a dom document with encoding utf8 */
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents("showtime.xml"), LIBXML_NOBLANKS);
        $root = $domtree->getElementsByTagName('showtimes')->item(0);
        
        /* Create showtime element */
        $xmlShowtime = $domtree->createElement("showtime");
        $xmlShowtime = $root->appendChild($xmlShowtime);
        $xmlShowtime->appendChild($domtree->createAttribute('id'));
        $xmlShowtime->setAttribute('id', $showtimeDetails['showtimeID']);

        /* elements inside showtime */
        $xmlShowtime->appendChild($domtree->createElement('date', $showtimeDetails['showDate']));
        $xmlShowtime->appendChild($domtree->createElement('time', getInHourMinuteFormat($showtimeDetails['showTime'])));
        $xmlShowtime->appendChild($xmlCinema = $domtree->createElement('cinema'));
        $xmlShowtime->appendChild($xmlMovie = $domtree->createElement('movie'));

        /* elements inside cinema */
        $xmlCinema->appendChild($domtree->createAttribute('id'));
        $xmlCinema->setAttribute('id', $showtimeDetails['cinemaID']);
        $xmlCinema->appendChild($domtree->createElement('name', $showtimeDetails['cinemaName']));
        $xmlCinema->appendChild($xmlHall = $domtree->createElement('hall'));

        /* elements inside hall */
        $xmlHall->appendChild($domtree->createAttribute('id'));
        $xmlHall->setAttribute('id', $showtimeDetails['hallID']);
        $xmlHall->appendChild($domtree->createElement('experience', $showtimeDetails['experience']));

        /* elements inside movie */
        $xmlMovie->appendChild($domtree->createAttribute('id'));
        $xmlMovie->setAttribute('id', $showtimeDetails['movieID']);
        $xmlMovie->appendChild($domtree->createElement('name', $showtimeDetails['movieName']));
        $xmlMovie->appendChild($domtree->createElement('ageRestriction', $showtimeDetails['ageRestriction']));

        /* get the xml printed */
        $domtree->save("showtime.xml");
    }

    private function createXML() {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;

        $xmlShowtimes = $domtree->createElement("showtimes");
        $xmlShowtimes = $domtree->appendChild($xmlShowtimes);
        $domtree->save("showtime.xml");
    }

    private function readFromXML($filename) {
        $xml = @file_get_contents($filename);

        if (trim($xml) == '') {
            $this->createXML();
        }
    }

}
