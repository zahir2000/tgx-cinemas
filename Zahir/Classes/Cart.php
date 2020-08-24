<?php

require_once 'Strategy/PaymentStrategy/PaymentStrategy.php';

/**
 * @author Zahiriddin Rustamov
 */
class Cart {

    private $tickets;
    private $showtimeId;
    private $paymentStrategy;

    function __construct($showtimeId = "") {
        $this->showtimeId = $showtimeId;
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

    function getShowtimeId() {
        return $this->showtimeId;
    }

    function setShowtimeId($showtimeId): void {
        $this->showtimeId = $showtimeId;
    }
    
    function getPaymentStrategy() {
        return $this->paymentStrategy;
    }

    function setPaymentStrategy($paymentStrategy): void {
        $this->paymentStrategy = $paymentStrategy;
    }

    function calculateTotal() {
        $sum = 0;
        foreach ($this->tickets as $ticket) {
            $sum += $ticket->cost($ticket->getType());
        }
        return $sum;
    }

    public function pay($userId) {
        $this->paymentStrategy->pay($userId);
    }

}
