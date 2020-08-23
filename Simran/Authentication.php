<?php
require_once '../Database/UserConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
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
                       
            $getUserDb = UserConnection::getInstance();
            $result = $getUserDb->getUserAccount($username);
            
            if($result != null){
                $pass = $result['password'];
            }else{
                $pass = '';
            }
            
            if(password_verify($password, $pass)){
                SessionHelper::login($username, $result['userID']);
                echo "Login Successful";
                return true;
                
            }else{
                echo "Login Unsuccessful! Username or password is invalid!";
                return false;
            }
            
        }else{
            echo "Do not leave the fields blank!";
            return false;
        }
    }
    
    


}
