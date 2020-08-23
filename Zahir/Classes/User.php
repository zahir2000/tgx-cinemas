<?php

/**
 * Description of User
 *
 * @author Zahir
 */
class User {
    
    private $userId;
    private $name;
    private $email;
    private $number;
    private $dob;
    private $gender;
    private $address;

    function __construct($userId = "", $name = "", $email = "", $number = "", $dob = "", $gender = "", $address = "") {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->address = $address;
    }
    
    function getUserId() {
        return $this->userId;
    }

    function setUserId($userId): void {
        $this->userId = $userId;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getNumber() {
        return $this->number;
    }

    function getDob() {
        return $this->dob;
    }

    function getGender() {
        return $this->gender;
    }

    function getAddress() {
        return $this->address;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setNumber($number): void {
        $this->number = $number;
    }

    function setDob($dob): void {
        $this->dob = $dob;
    }

    function setGender($gender): void {
        $this->gender = $gender;
    }

    function setAddress($address): void {
        $this->address = $address;
    }
    
    public function __toString() {
        return $this->userId . "<br/>"
                . $this->name . "<br/>"
                . $this->email  . "<br/>"
                . $this->number  . "<br/>"
                . $this->dob  . "<br/>"
                . $this->gender  . "<br/>"
                . $this->address  . "<br/>";
    }


}