<?php

/**
 * @author Zahiriddin Rustamov
 */
class Token {

    private $key;
    private $expiryTime;
    private $sessionToken;
    private $cookieToken;

    function __construct($key = "", $expiryTime = "", $sessionToken = "", $cookieToken = "") {
        $this->key = $key;
        $this->expiryTime = $expiryTime;
        $this->sessionToken = $sessionToken;
        $this->cookieToken = $cookieToken;
    }

    function getKey() {
        return $this->key;
    }

    function getExpiryTime() {
        return $this->expiryTime;
    }

    function getSessionToken() {
        return $this->sessionToken;
    }

    function getCookieToken() {
        return $this->cookieToken;
    }

    function setKey($key): void {
        $this->key = $key;
    }

    function setExpiryTime($expiryTime): void {
        $this->expiryTime = $expiryTime;
    }

    function setSessionToken($sessionToken): void {
        $this->sessionToken = $sessionToken;
    }

    function setCookieToken($cookieToken): void {
        $this->cookieToken = $cookieToken;
    }

}
