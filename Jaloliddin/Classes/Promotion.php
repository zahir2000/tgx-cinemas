<?php

/**
 * Description of Promotion
 *
 * @author Jaloliddin
 */
class Promotion {

    private $promotionID;
    private $name; //string
    private $description; //string
    private $rate; //double
    private $date; //date
    private $photo; //string
    private Admin $admin;

    function __construct($promotionID="", $name="", $description="", $rate=0.0, $date="", $photo="", Admin $admin=NULL) {
        $this->promotionID = $promotionID;
        $this->name = $name;
        $this->description = $description;
        $this->rate = $rate;
        $this->date = $date;
        $this->photo = $photo;
        $this->admin = $admin;
    }

    function getPromotionID() {
        return $this->promotionID;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getRate() {
        return $this->rate;
    }

    function getDate() {
        return $this->date;
    }

    function getPhoto() {
        return $this->photo;
    }

    function setPromotionID($promotionID): void {
        $this->promotionID = $promotionID;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setDescription($description): void {
        $this->description = $description;
    }

    function setRate($rate): void {
        $this->rate = $rate;
    }

    function setDate($date): void {
        $this->date = $date;
    }

    function setPhoto($photo): void {
        $this->photo = $photo;
    }

    function getAdmin(): Admin {
        return $this->admin;
    }

    function setAdmin(Admin $admin): void {
        $this->admin = $admin;
    }

}
