<?php
require_once 'Booking.php';
/**
 * Description of bookingDOMParser
 *
 * @author Zahir
 */
class BookingDOMParser {

    private $booking;

    public function __construct($filename) {
        $this->booking = new SplObjectStorage();
        $this->readFromXML($filename);
        //$this->display();
    }

    public function readFromXML($filename) {
        $xml = simplexml_load_file($filename);
        $bookingList = $xml->booking; // retrieve all the employee nodes

        foreach ($bookingList as $booking) {
            $attr = $booking->attributes();
            //$empTemp = new Employee($attr->id,
            //        $emp->firstName,
            //        $emp->lastName,
            //        $emp->location);
            
            echo $attr->date;

            //$this->employees->attach($empTemp);
        }
    }

    public function display() {
        echo "<h2>Employee Listing </h2>";
        foreach ($this->employees as $emp) {
            print $emp . "<br />";
        }
    }

}
