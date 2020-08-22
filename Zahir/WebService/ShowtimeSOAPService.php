<?php

require_once '../../lib/nusoap.php';
require_once '../../Database/DatabaseConnection.php';
require_once '../../Database/BookingConnection.php';

$server = new nusoap_server();

$server->configureWSDL("Showtimes Web Service", "urn:showtimesAPI");

$server->wsdl->addComplexType(
        'showtimeArray', // MySoapObjectArray
        'complexType', 'array', '', 'SOAP-ENC:Array',
        array(),
        array(array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:return_array_php[]')), 'tns:return_array_php'
);

$server->wsdl->addComplexType('return_array_php',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'showTime' => array('showTime' => 'showTime', 'type' => 'xsd:int'),
            'showDate' => array('showDate' => 'showDate', 'type' => 'xsd:string'),
            'cinemaName' => array('cinemaName' => 'cinemaName', 'type' => 'xsd:string'),
            'hallID' => array('hallID' => 'hallID', 'type' => 'xsd:int'),
            'experience' => array('experience' => 'experience', 'type' => 'xsd:string'),
        )
);

$server->wsdl->addComplexType(
        'movieArray', // MySoapObjectArray
        'complexType', 'array', '', 'SOAP-ENC:Array',
        array(),
        array(array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:return_movie_array[]')), 'tns:return_movie_array'
);

$server->wsdl->addComplexType('return_movie_array',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'movieName' => array('movieName' => 'movieName', 'type' => 'xsd:string'),
            'movieID' => array('movieID' => 'movieID', 'type' => 'xsd:int')
        )
);

$server->register(
        'fetchShowtimeDetails',
        array('movieID' => 'xsd:string'),
        array('return' => 'tns:showtimeArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchShowtimeDetails');

$server->register(
        'fetchMovies',
        array(),
        array('return' => 'tns:movieArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchMovies');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
@$server->service(file_get_contents("php://input"));

function fetchShowtimeDetails($movieID) {
    $db = DatabaseConnection::getInstance();

    $queryDate = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience "
            . "FROM showtime S, movie M, hall H, cinema C "
            . "WHERE S.movieID = ? AND S.movieID = M.movieID "
            . "AND S.hallID = H.hallID "
            . "AND H.cinemaID = C.cinemaID "
            . "ORDER BY C.name, H.hallID, S.showDate, S.showTime;";

    $stmtDate = $db->getDb()->prepare($queryDate);
    $stmtDate->bindParam(1, $movieID, PDO::PARAM_STR);
    $stmtDate->execute();

    if ($stmtDate->rowCount() != 0) {
        $showtime = $stmtDate->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $showtime = NULL;
    }

    return $showtime;
}

function fetchMovies() {
    $con = new BookingConnection();
    return $con->getMovies();
}
