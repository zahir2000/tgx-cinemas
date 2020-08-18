<?php

/**
 * Description of Booking
 *
 * @author Zahir
 */
class Booking {

    private $date;
    private $noOfAdults;
    private $noOfKids;
    private $paymentMethod;
    private $totalPrice;
    private $user;

    function __construct($date = "", $noOfAdults = "", $noOfKids = "", $paymentMethod = "", $totalPrice = "", $user = "") {
        $this->date = $date;
        $this->noOfAdults = $noOfAdults;
        $this->noOfKids = $noOfKids;
        $this->paymentMethod = $paymentMethod;
        $this->totalPrice = $totalPrice;
        $this->user = $user;
    }

    function getDate() {
        return $this->date;
    }

    function getNoOfAdults() {
        return $this->noOfAdults;
    }

    function getNoOfKids() {
        return $this->noOfKids;
    }

    function getPaymentMethod() {
        return $this->paymentMethod;
    }

    function getTotalPrice() {
        return $this->totalPrice;
    }

    function getUser() {
        return $this->user;
    }

    function setDate($date): void {
        $this->date = $date;
    }

    function setNoOfAdults($noOfAdults): void {
        $this->noOfAdults = $noOfAdults;
    }

    function setNoOfKids($noOfKids): void {
        $this->noOfKids = $noOfKids;
    }

    function setPaymentMethod($paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
    }

    function setTotalPrice($totalPrice): void {
        $this->totalPrice = $totalPrice;
    }

    function setUser($user): void {
        $this->user = $user;
    }

}
