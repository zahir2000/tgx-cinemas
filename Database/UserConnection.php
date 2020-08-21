<?php

/**
 *
 * @author Harrsimran Kaur
 */

require_once 'DatabaseConnection.php';

class UserConnection {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }
    
    public function addUser($name, $email, $number, $dob, $gender, $address, $username, $password){
        $query = "INSERT INTO user(name, email, number, dob, gender, address, username, password)" 
                 . "VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $number);
        $stmt->bindParam(4, $dob);
        $stmt->bindParam(5, $gender);
        $stmt->bindParam(6, $address);
        $stmt->bindParam(7, $username);
        $stmt->bindParam(8, $password);
        $stmt->execute();
    }
    
    public function getUserAccount($username, $password){
        $query = "SELECT username, password FROM user WHERE username = ? AND password = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $password, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }else{
            return null;
        }
    }
}
