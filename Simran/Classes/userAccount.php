<?php
/**
 * Description of userAccount
 *
 * @author Harrsimran Kaur
 */
class userAccount {
    private $username;
    private $password;
    
    public function __construct($username="", $password="") {
        $this->username = $username;
        $this->password = $password;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }
}
