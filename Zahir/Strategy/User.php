<?php

/**
 * Description of User
 *
 * @author Zahir
 */
class User {

    private $name;
    private $email;
    private $number;
    private $dob;
    private $gender;
    private $photo;
    private $address;
    private $state;
    private $creationDate;
    private $username;
    private $password;
    private $lastLoginDate;

    function __construct($name = "", $email = "", $number = "", $dob = "", $gender = "", $photo = "",
            $address = "", $state = "", $creationDate = "", $username = "", $password = "", $lastLoginDate = "") {
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->photo = $photo;
        $this->address = $address;
        $this->state = $state;
        $this->creationDate = $creationDate;
        $this->username = $username;
        $this->password = $password;
        $this->lastLoginDate = $lastLoginDate;
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

    function getPhoto() {
        return $this->photo;
    }

    function getAddress() {
        return $this->address;
    }

    function getState() {
        return $this->state;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getLastLoginDate() {
        return $this->lastLoginDate;
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

    function setPhoto($photo): void {
        $this->photo = $photo;
    }

    function setAddress($address): void {
        $this->address = $address;
    }

    function setState($state): void {
        $this->state = $state;
    }

    function setCreationDate($creationDate): void {
        $this->creationDate = $creationDate;
    }

    function setUsername($username): void {
        $this->username = $username;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setLastLoginDate($lastLoginDate): void {
        $this->lastLoginDate = $lastLoginDate;
    }

}
