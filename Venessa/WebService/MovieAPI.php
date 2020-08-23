<?php
header("Content-Type:application/json");
include '../MovieConnection.php';

/**
 * Description of MovieAPI
 *
 * @author: Venessa Choo Wei Ling
 */
if (!empty($_GET['movieName'])) {
    $movieConn = new MovieConnection();
    $movieName = $_GET['movieName'];
    $releaseDate = $movieConn->getReleaseDateOfMovie($movieName);

    if ($releaseDate == NULL) {
        response(200, "Movie Not Found", NULL);
    } else {
        response(200, "Movie Found", $releaseDate);
    }
} else {
    response(400, "Invalid Request", NULL);
}

function response($status, $status_message, $data) {
    header("HTTP/1.1 " . $status);

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}
?>