<?php

/**
 *
 * @author Harrsimran Kaur
 */

require_once 'DatabaseConnection.php';

class UserConnection {
    private static $instance;
    private $db;
    
    private function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }
    
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new UserConnection();
        }
        return self::$instance;
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
    
    public function getUserAccount($username){
        $query = "SELECT username, password FROM user WHERE username = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $result = "No such username or password";
            echo $result;
        }
    }
    
    public function getUserDetails($userID){
        $query = "SELECT name, email, number, dob, gender, address FROM user WHERE userID = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $userID, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }else {
            return null;
        }
    }
    
    /*public function getUsername($username){
        $query = "SELECT userID FROM user WHERE username = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }else{
            return null;
        }
    }*/
}
