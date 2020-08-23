<?php

require_once '../lib/nusoap.php';
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';

function addNewUser($username, $password){
    
}


$server = new nusoap_server();

$server->configureWSDL("service", "urn:service");