<?php

class SeatXSLT {

    private $xmlFile = 'RegularSeatLayout.xml';
    private $xmlFileUpdated = 'RegularSeatLayoutSold.xml';
    private $xslFile = 'RegularSeatLayout.xsl';

    public function __construct($showtimeId) {
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

        $query = "SELECT seat "
                . "FROM Ticket "
                . "WHERE showtimeID = ? ";

        $stmt = $db->getDb()->prepare($query);
        $stmt->bindParam(1, $showtimeId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $seat) {
                $row = $seat['seat'][0];
                $seatNo = $seat['seat'][1];

                foreach ($xpath->evaluate("/hall/row[@id='$row']/seat[@id='$seatNo']") as $seat) {
                    $seat->nodeValue = '';
                    $seat->appendChild($document->createTextNode('Booked'));
                }
            }
        }

        $document->save($this->xmlFileUpdated);
        $db->closeConnection();
    }

}
