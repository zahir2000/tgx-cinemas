<?php

require_once '../ArrayList/ArrayList.php';
require_once 'PaymentStrategy.php';

/**
 * Description of Booking
 *
 * @author Zahir
 */
class Booking {

    private $bookingDate;
    private $adultsNo;
    private $kidsNo;
    private $paymentMethod;
    private $user;
    private $tickets;

    function __construct($bookingDate = "", $adultsNo = "", $kidsNo = "", $paymentMethod = "", $user = "") {
        $this->bookingDate = $bookingDate;
        $this->adultsNo = $adultsNo;
        $this->kidsNo = $kidsNo;
        $this->paymentMethod = $paymentMethod;
        $this->user = $user;
        $this->tickets = new ArrayList();
    }

    function addTicket($ticket) {
        $this->tickets->add($ticket);
    }

    function removeTicket($ticket) {
        $this->tickets->remove($ticket);
    }

    function getPaymentMethod() {
        return $this->paymentMethod;
    }

    function setPaymentMethod($paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
    }

    function pay() {
        $this->paymentMethod->pay();
    }

}
