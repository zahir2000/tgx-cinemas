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

        $checkShowtime = $booking->getElementsByTagName('showtime');
        foreach ($checkShowtime as $node) {
            $node->parentNode->removeChild($node);
        }

        foreach ($exp->query('//showtime[@id=' . $showtimeId . "]") as $item) {
            $root->appendChild($booking->importNode($item, TRUE));
        }

        $booking->save($this->xmlFile);
    }

    public function createSeatElement() {
        $seats = new DOMDocument('1.0', 'UTF-8');
        $seats->load('SelectedSeats/SelectedSeats' . $this->userId . '.xml');
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

    public function addPaymentMethod($paymentMethod, $credentials, $totalPrice) {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $payment = $domtree->getElementsByTagName('payment')->item(0);

        /* create payment method element */
        //$payment = $domtree->createElement("payment");
        //$payment = $root->appendChild($payment);
        
        $payment->appendChild($domtree->createElement('method', $paymentMethod));

        switch (strtolower($paymentMethod)) {
            case 'paypal':
                $payment->appendChild($domtree->createElement('email', $credentials));
                break;
            case 'credit card':
                $payment->appendChild($domtree->createElement('name', $credentials));
                break;
            default :
                echo "Invalid Payment Method";
        }

        $payment->appendChild($domtree->createElement('totalPrice', $totalPrice));
        
        $domtree->save($this->xmlFile);
    }
    
    public function addPeopleCount($noOfAdults, $noOfKids){
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $root = $domtree->getElementsByTagName('booking')->item(0);
        
        $checkPayment = $domtree->getElementsByTagName('payment');
        foreach ($checkPayment as $node) {
            $node->parentNode->removeChild($node);
        }
        
        $payment = $domtree->createElement("payment");
        $payment = $root->appendChild($payment);
        
        $payment->appendChild($domtree->createElement('noOfAdults', $noOfAdults));
        $payment->appendChild($domtree->createElement('noOfKids', $noOfKids));
        
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
