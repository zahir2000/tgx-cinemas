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
    private $username;
    private $password;

    function __construct($userId = "", $name = "", $email = "", $number = "", $dob = "", $gender = "", $address = "", $username = "", $password = "") {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->address = $address;
        $this->username = $username;
        $this->password = $password;
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

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
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

    function setUsername($username): void {
        $this->username = $username;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

}