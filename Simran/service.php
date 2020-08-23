<?php
require_once '../lib/nusoap.php';
require_once '../Database/DatabaseConnection.php';

function authenticateLoginService($username, $password){
    if(!empty($username) && !empty($password)){
        $con = DatabaseConnection::getInstance();
        
        $query = "SELECT username, password, userID FROM user WHERE username = ?";
        $stmt = $con->getDb()->prepare($query);
        $stmt->bindParam(1, "username", PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $result = null;
        }

        if(password_verify($password, $result['password'])){
            SessionHelper::login($username, $result['userID']);
            echo "Login Successful";
            return true;
        }else{
            echo "Login Unsuccessful!Username or password is invalid!";
            return false;
        }
        
    }else{
        echo "Please Do Not Leave Any Fields Blank!";
        return false;
    }         
}

$server = new nusoap_server();

$server->configureWSDL("service", "urn:service");

$server->register("authenticateLoginService",
        array("username" => "xsd:string",
            "password" => "xsd:string"),
        array("result" => "xsd:Boolean"),
        'urn:service',
        'urn:service#authenticateLoginService');

$server->service(file_get_contents("php://input"));