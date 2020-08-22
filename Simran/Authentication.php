<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
/**
 * Description of Authentication
 *
 * @author Harrsimran Kaur
 */
class Authentication {
    public $error;
    public $success;
       
    public function __construct() {
        
    }
    
    public static function authenticateRegister($name, $email, $number, $dob, $gender, $address, $username, $password){
        if(!empty($name) && !empty($email) && !empty($number) && !empty($dob) && !empty($gender) && !empty($address) && !empty($username) && !empty($password)){
            if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,16}$/', $password)) {
                
                $db = DatabaseConnection::getInstance();
                $userDb = UserConnection::getInstance();
                $userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, password_hash($password, PASSWORD_DEFAULT));
                
                $success = "Registration Successful";
                echo $success;
                
                $db->closeConnection();
            }else{
                $error = "Please follow standards that was given for password!";
                echo $error;
            }
            
        }else {
            $error = "Please Do Not Leave Any Fields Blank!";
            echo $error;
        }
    }
    
    


}
