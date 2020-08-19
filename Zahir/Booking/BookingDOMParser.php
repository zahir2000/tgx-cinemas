<?php

require_once 'Classes/Booking.php';

/**
 * Description of bookingDOMParser
 *
 * @author Zahir
 */
class BookingDOMParser {

    private $doc;
    private $xpath;

    public function __construct($userId) {
        $this->doc = new DOMDocument();
        $this->doc->load('Booking/Booking' . $userId . '.xml');
        $this->xpath = new DOMXPath($this->doc);
    }

    public function retrieveBookingDetails() {
        $booking = new Booking(date("Y-m-d"));
        $booking->setNoOfAdults($this->getNoOfAdults());
        $booking->setNoOfKids($this->getNoOfKids());
        $booking->setPaymentMethod($this->getPaymentMethod());
        $booking->setCredentials($this->getCredentials());
        $booking->setTotalPrice($this->getTotalPrice());

        return $booking;
    }
    
    private function getTotalPrice(){
        $expr = ('//totalPrice');
        $price = $this->xpath->query($expr);
        
        if($price->length == 1){
            foreach ($price as $item){
                return $item->nodeValue;
            }
        }
        
        return 0;
    }
    
    private function getCredentials(){
        $expr = ('//email|//payment/name');
        $credentials = $this->xpath->query($expr);
        
        if($credentials->length == 1){
            foreach ($credentials as $item){
                return $item->nodeValue;
            }
        }
        
        return 0;
    }
    
    private function getNoOfAdults(){
        $expr = ('//noOfAdults');
        $adultCount = $this->xpath->query($expr);
        
        if($adultCount->length == 1){
            foreach ($adultCount as $item){
                return $item->nodeValue;
            }
        }
        
        return 0;
    }
    
    private function getNoOfKids(){
        $expr = ('//noOfKids');
        $kidCount = $this->xpath->query($expr);
        
        if($kidCount->length == 1){
            foreach ($kidCount as $item){
                return $item->nodeValue;
            }
        }
        
        return 0;
    }
    
    private function getPaymentMethod(){
        $expr = ('//method');
        $method = $this->xpath->query($expr);
        
        if($method->length == 1){
            foreach ($method as $item){
                return $item->nodeValue;
            }
        }
        
        return "Unknown";
    }

}
