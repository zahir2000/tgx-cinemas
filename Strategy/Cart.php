<?php

require_once 'PaymentStrategy/PaymentStrategy.php';

/**
 * Description of Booking
 *
 * @author Zahir
 */
class Cart {

    private $tickets;

    function __construct() {
        $this->tickets = array();
    }

    function addTicket($ticket) {
        array_push($this->tickets, $ticket);
    }
    
    function getTickets() {
        return $this->tickets;
    }

    function setTickets($tickets): void {
        $this->tickets = $tickets;
    }

    function calculateTotal() {
        $sum = 0;
        foreach ($this->tickets as $ticket) {
            $sum += $ticket->cost($ticket->getType());
        }
        return $sum;
    }

    public function pay($paymentMethod) {
        $amount = $this->calculateTotal();
        $paymentMethod->pay($amount);
    }

}
