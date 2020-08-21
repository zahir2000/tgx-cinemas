<?php

/**
 *
 * @author Harrsimran Kaur
 */

require_once 'DatabaseConnection.php';

class UserConnection {
    private $db;
    
    public function __construct($db) {
        $this->db = DatabaseConnection::getInstance();
    }
    
    public function addUser($name, $email, $number, $dob, $gender, $address, $username, $password){
        $query = "INSERT INTO user(name, email, number, dob, gender, address, username, password)" 
                 . "VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->setDb()->prepare($query);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $number);
        $stmt->bindParam(5, $dob);
        $stmt->bindParam(6, $gender);
        $stmt->bindParam(7, $address);
        $stmt->bindParam(8, $username);
        $stmt->bindParam(9, $password);
        $stmt->execute();
    }
}
