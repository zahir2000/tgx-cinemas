<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
/**
 * Description of Authentication
 *
 * @author Harrsimran Kaur
 */
class Authentication {
       
    public function __construct() {
        
    }
    
    public static function validatePassword($name, $email, $number, $dob, $gender, $address, $username, $password){
        if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,16}$/', $password)) {                         
            $db = DatabaseConnection::getInstance();
            $userDb = UserConnection::getInstance();
            $userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, password_hash($password, PASSWORD_DEFAULT));
                
            echo "Registration Successful";
                
            $db->closeConnection();
        }else{
            echo "Please follow standards that was given for password!";
        }          
    }
    
    public static function authenticateLogin($username, $password){
        if(!empty($username) && !empty($password)){
                       
            $db = DatabaseConnection::getInstance();
            $getUserDb = UserConnection::getInstance();
            $result = $getUserDb->getUserAccount($username);
            //$user = $result['username'];
            $pass = $result['password'];
            
            if(password_verify($password, $pass)){
                echo "Login Successful";
            }else{
                echo "Login Unsuccessful! Username or password is invalid!";
            }    
            
            $db->closeConnection();
            
        }else{
            echo "Do not leave the fields blank!";
        }
    }
    
    


}
