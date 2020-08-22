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
    
    public function __construct($error, $success) {
        $this->error = $error;
        $this->success = $success;
    }
    
    public function authenticateRegister($name, $email, $number, $dob, $gender, $address, $username, $password){
        if(!empty($name) && !empty($email) && !empty($number) && !empty($dob) && !empty($gender) && !empty($address) && !empty($username) && !empty($password)){
            if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,16}$/', $password)) {
                
                $db = databaseConnection::getInstance();
                $userDb = UserConnection::getInstance();
                $userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, password_hash($password, PASSWORD_DEFAULT));
                
                $this->success = "Registration Successful";
                echo $this->success;
            }else{
                $this->error = "Please follow standards of password!";
                echo $this->error;
            }
            
        }else {
            $this->error = "Please Do Not Leave Any Fields Blank!";
            echo $this->error;
        }
    }


}
