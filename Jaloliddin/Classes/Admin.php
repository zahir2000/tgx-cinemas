<?php

/**
 * Admin Class
 *
 * @author Jaloliddin
 */
class Admin {

    private $username;
    private $password;

    function __construct($username = "", $password = "") {
        $this->username = $username;
        $this->password = $password;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function setUsername($username): void {
        $this->username = $username;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

}
