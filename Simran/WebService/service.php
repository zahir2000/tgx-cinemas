<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/lib/nusoap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Simran/SecureCodingPrac/Authentication.php';

$server = new nusoap_server();

$server->configureWSDL("Authentication Services", "urn:authenticateService");

$server->register("authenticateLoginService",
        array("username" => "xsd:string",
            "password" => "xsd:string"),
        array("result" => "xsd:int"),
        'urn:Authentication Services',
        'urn:Authentication Services#authenticateService');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
@$server->service(file_get_contents("php://input"));

function authenticateLoginService($username, $password){
    if(!empty($username) && !empty($password)){
        $result = Authentication::authenticateLogin($username, $password);
        return $result;
    }else{
        echo "Please Do Not Leave Any Fields Blank!";
        return false;
    }         
}

