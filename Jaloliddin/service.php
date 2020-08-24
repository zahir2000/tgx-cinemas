<?php

require_once '../lib/nusoap.php';
require_once '../Database/DatabaseConnection.php';

//require_once 'Classes/Movie.php';

function GetMovieDetails($name) {
    $connect = DatabaseConnection::getInstance();

    $query = "SELECT * FROM movie WHERE (name LIKE '%$name%')";
    $stmt = $connect->getDb()->prepare($query);
    $stmt->bindParam(1, $name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return json_encode($result);
    } else {
        return null;
    }
}

$server = new nusoap_server(); //create an instance of NUSOAP server

$server->configureWSDL("service", "urn:service");

$server->register("GetMovieDetails",
        array("name" => "xsd:string"),
        array("result" => "xsd:string"),
        'urn:service',
        'urn:service#GetMovieDetails'
);

$server->service(file_get_contents("php://input"));