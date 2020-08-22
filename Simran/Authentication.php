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
    
    public static function validateRegister($name, $email, $number, $dob, $gender, $address, $username, $password){
        if(!empty($name) && !empty($email) && !empty($number) && !empty($dob) && !empty($gender) && !empty($address) && !empty($username) && !empty($password)){
            if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,16}$/', $password)) {
                
                $db = DatabaseConnection::getInstance();
                $userDb = UserConnection::getInstance();
                $userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, password_hash($password, PASSWORD_DEFAULT));
                
                echo "Registration Successful";
                
                $db->closeConnection();
            }else{
                echo "Please follow standards that was given for password!";
            }
            
        }else {
            echo "Please Do Not Leave Any Fields Blank!";
        }
    }
    
    public static function authenticateLogin($username, $password){
        if(!empty($username) && !empty($password)){
            
            $db = DatabaseConnection::getInstance();
            $getUserDb = UserConnection::getInstance();
            $getUserDb->getUserAccount($username, $password);
                
            echo "Login Successful";
            
            $db->closeConnection();
            
        }else{
            echo "Please Do Not Leave Any Fields Blank!";
        }
    }
    
    


}
