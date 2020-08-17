<?php

/**
 * Description of BookingXMLBuilder
 *
 * @author Zahir
 */
class BookingXML {

    private $xmlFile;
    private $userId;

    public function __construct($userId) {
        $this->userId = $userId;
        $this->xmlFile = "Booking/Booking" . $this->userId . ".xml";

        $this->readFromXML($this->xmlFile);
    }

    public function createBookingElement($showtimeId) {
        $showtimes = new DOMDocument('1.0', 'UTF-8');
        $showtimes->load('Showtime.xml');
        $showtimes->formatOutput = true;
        $exp = new DOMXPath($showtimes);

        $booking = new DOMDocument('1.0', 'UTF-8');
        $booking->formatOutput = true;
        $booking->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $root = $booking->getElementsByTagName('booking')->item(0);

        if ($this->showtimeExists($showtimeId)) {
            return;
        }

        foreach ($exp->query('/showtimes/showtime[@id=' . $showtimeId . "]") as $item) {
            $root->appendChild($booking->importNode($item, TRUE));
        }

        $booking->save($this->xmlFile);
    }

    public function createSeatElement() {
        $seats = new DOMDocument('1.0', 'UTF-8');
        $seats->load('UserSeats/UserSeats' . $this->userId . '.xml');
        $seats->formatOutput = true;
        $exp = new DOMXPath($seats);

        $booking = new DOMDocument('1.0', 'UTF-8');
        $booking->formatOutput = true;
        $booking->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $root = $booking->getElementsByTagName('booking')->item(0);

        $checkSeats = $booking->getElementsByTagName('seats');
        foreach ($checkSeats as $node) {
            $node->parentNode->removeChild($node);
        }

        foreach ($exp->query("//seats") as $seats) {
            $root->appendChild($booking->importNode($seats, TRUE));
        }

        $booking->save($this->xmlFile);
    }

    private function showtimeExists($showtimeId) {
        $booking = new DOMDocument;
        $booking->load($this->xmlFile);
        $booking->formatOutput = true;
        $path = new DOMXPath($booking);
        $exp = ('/booking/showtime[@id=' . $showtimeId . ']');
        $exists = $path->query($exp);

        if ($exists->length > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function append($showtimeDetails) {
        $xpath = new ShowtimeXPath($this->xmlFile);

        if (!$xpath->checkId($showtimeDetails['showtimeID'])) {
            $this->createElement($showtimeDetails);
        }
    }

    private function createElement($showtimeDetails) {
        /* create a dom document with encoding utf8 */
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $root = $domtree->getElementsByTagName('showtimes')->item(0);

        /* Create showtime element */
        $xmlShowtime = $domtree->createElement("showtime");
        $xmlShowtime = $root->appendChild($xmlShowtime);
        $xmlShowtime->appendChild($domtree->createAttribute('id'));
        $xmlShowtime->setAttribute('id', $showtimeDetails['showtimeID']);

        /* elements inside showtime */
        $xmlShowtime->appendChild($domtree->createElement('date', $showtimeDetails['showDate']));
        $xmlShowtime->appendChild($domtree->createElement('time', GeneralUtilities::getInHourMinuteFormat($showtimeDetails['showTime'])));
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

        /* save the xml */
        $domtree->save($this->xmlFile);
    }

    private function createXML() {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;

        $booking = $domtree->createElement("booking");
        $booking = $domtree->appendChild($booking);
        $domtree->save($this->xmlFile);
    }

    private function readFromXML($xmlFile) {
        $xml = @file_get_contents($xmlFile);

        if (trim($xml) == '') {
            $this->createXML();
        }
    }

}
