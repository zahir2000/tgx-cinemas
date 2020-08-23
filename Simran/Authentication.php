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
    
    public static function validatePassword($password){
        if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,16}$/', $password)) {                         
            
            return true;
        }else{
            return false;

        }          
    }
    
    public static function authenticateLogin($username, $password){
        if(!empty($username) && !empty($password)){
                       
            $db = DatabaseConnection::getInstance();
            $getUserDb = UserConnection::getInstance();
            $result = $getUserDb->getUserAccount($username);
            
            if($result != null){
                $pass = $result['password'];
            }else{
                $pass = '';
            }
            
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
