<?php

/**
 * Description of TicketBooking
 *
 * @author Zahir
 */
class TicketBooking {

    private $price;
    private $discount;
    private $booking;
    private $ticket;

    function __construct($price = "", $discount = "", $booking = "", $ticket = "") {
        $this->price = $price;
        $this->discount = $discount;
        $this->booking = $booking;
        $this->ticket = $ticket;
    }

}
