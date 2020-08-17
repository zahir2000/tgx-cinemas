<?php

/**
 * Description of UserSeats
 *
 * @author Zahir
 */
class UserSeats {

    private $xmlFile;
    private $selectedSeats;

    public function __construct($userId) {
        $this->xmlFile = "UserSeats/UserSeats" . $userId . ".xml";
        $this->selectedSeats = $_SESSION['selectedSeats'];
        $this->createXML();
    }

    private function createXML() {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;

        $seats = $domtree->createElement("seats");
        $seats = $domtree->appendChild($seats);

        foreach ($this->selectedSeats as $selectedSeat) {
            $seat = $domtree->createElement("seat");
            $seat = $seats->appendChild($seat);

            $seat->appendChild($domtree->createAttribute('id'));
            $seat->setAttribute('id', substr($selectedSeat, 0, 2));

            $seat->appendChild($domtree->createElement('type', ucfirst(substr($selectedSeat, 2))));
        }

        $domtree->save($this->xmlFile);
    }

}
