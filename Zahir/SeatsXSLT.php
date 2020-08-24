<?php

/**
 * @author Zahiriddin Rustamov
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/ShowtimeXPath.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';

class SeatsXSLT {

    private $xmlFile = 'SeatLayout/Templates/RegularSeatLayout.xml';
    private $xmlFileUpdated;
    private $xslFile = 'SeatLayout/SeatLayout.xsl';
    private $hall = "";

    public function __construct($showtimeId) {
        $showtimeXpath = new ShowtimeXPath($_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Showtime.xml');
        $hallType = $showtimeXpath->getHallType($showtimeId);

        foreach ($hallType as $hall) {
            $this->hall = $this->hall . $hall;
        }

        $this->xmlFile = $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/SeatLayout/Templates/' . $this->hall . 'SeatLayout.xml';

        $this->generateSoldSeats($showtimeId);
        $this->generateSeatLayout();
    }

    private function generateSeatLayout() {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($this->xmlFileUpdated);

        $xsl = new DOMDocument();
        $xsl->load($this->xslFile);

        $proc = new XSLTProcessor();
        $proc->registerPHPFunctions();
        $proc->importStylesheet($xsl);

        echo $proc->transformToXml($xmlDoc);
    }

    private function generateSoldSeats($showtimeId) {
        $db = DatabaseConnection::getInstance();

        $document = new DOMDocument();
        $document->load($this->xmlFile);
        $xpath = new DOMXpath($document);

        $con = BookingConnection::getInstance();
        $result = $con->getBookedSeats($showtimeId);

        if (!is_null($result)) {
            foreach ($result as $seat) {
                $row = $seat['seat'][0];
                $seatNo = $seat['seat'][1];

                foreach ($xpath->evaluate("/hall/row[@id='$row']/seat[@id='$seatNo']") as $seat) {
                    $seat->nodeValue = '';
                    $seat->appendChild($document->createTextNode('Booked'));
                }
            }
        }

        $this->xmlFileUpdated = $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/SeatLayout/Booked/' . $this->hall . 'SeatLayoutSold' . $showtimeId . '.xml';
        $document->save($this->xmlFileUpdated);
        $db->closeConnection();
    }

}
