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
                 . "VALUES ('$name', '$email', '$number', '$dob', '$gender', '$address', '$username', '$password')";
        $stmt = $this->db->getDb()->prepare($query);
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
    
    public function getUserAccount($username, $password){
        $query = "SELECT username, password FROM user WHERE username = $username AND password = $password";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(8, $username, PDO::PARAM_STR);
        $stmt->bindParam(9, $password, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }else{
            return null;
        }
    }
}
