<?php
/**
 * Description of User
 *
 * @author Harrsimran Kaur
 */
class User {
    private $userID;
    private $name;
    private $email;
    private $number;
    private $dob;
    private $gender;
    private $address;
    
    public function __construct($userID="", $name="", $email="", $number="", $dob="", $gender="", $address="") {
        $this->userID = $userID;
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->address = $address;
    }
    
    public function getUserID() {
        return $this->userID;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getDob() {
        return $this->dob;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setUserID($userID): void {
        $this->userID = $userID;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setNumber($number): void {
        $this->number = $number;
    }

    public function setDob($dob): void {
        $this->dob = $dob;
    }

    public function setGender($gender): void {
        $this->gender = $gender;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }
}
