<?php
require_once '../lib/nusoap.php';
require_once '../Database/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Simran/Authentication.php';

$server = new nusoap_server();

$server->configureWSDL("service", "urn:service");

$server->register("authenticateLoginService",
        array("username" => "xsd:string",
            "password" => "xsd:string"),
        array("result" => "xsd:int"),
        'urn:service',
        'urn:service#authenticateLoginService');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
@$server->service(file_get_contents("php://input"));

function authenticateLoginService($username, $password){
    if(!empty($username) && !empty($password)){
        $result = Authentication::authenticateLogin($username, $password);
        return $result;
    }else{
        echo "Please Do Not Leave Any Fields Blank!";
        return true;
    }         
}

