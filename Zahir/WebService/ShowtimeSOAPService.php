<?php
/**
 * @author Zahiriddin Rustamov
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/lib/nusoap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Utility/GeneralUtilities.php';

$server = new nusoap_server();

$server->configureWSDL("Showtimes Web Service", "urn:showtimesAPI");

$server->wsdl->addComplexType(
        'showtimeArray',
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
            'price' => array('price' => 'price', 'type' => 'xsd:decimal')
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

$server->wsdl->addComplexType(
        'cinemaArray', // MySoapObjectArray
        'complexType', 'array', '', 'SOAP-ENC:Array',
        array(),
        array(array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:return_cinema_array[]')), 'tns:return_cinema_array'
);

$server->wsdl->addComplexType('return_cinema_array',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'cinemaName' => array('cinemaName' => 'cinemaName', 'type' => 'xsd:string'),
            'cinemaID' => array('cinemaID' => 'cinemaID', 'type' => 'xsd:int')
        )
);

$server->wsdl->addComplexType(
        'experienceArray', // MySoapObjectArray
        'complexType', 'array', '', 'SOAP-ENC:Array',
        array(),
        array(array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:return_experience_array[]')), 'tns:return_experience_array'
);

$server->wsdl->addComplexType('return_experience_array',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'experience' => array('experience' => 'experience', 'type' => 'xsd:string'),
        )
);

$server->register(
        'fetchShowTime',
        array('movieID' => 'xsd:int', 'date' => 'xsd:date', 'cinemaID' => 'xsd:int', 'experience' => 'xsd:string'),
        array('return' => 'tns:showtimeArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchShowTime');

$server->register(
        'fetchMovies',
        array(),
        array('return' => 'tns:movieArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchMovies');

$server->register(
        'fetchCinemas',
        array(),
        array('return' => 'tns:cinemaArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchCinemas');

$server->register(
        'fetchExperiences',
        array(),
        array('return' => 'tns:experienceArray'),
        'urn:showtimesAPI',
        'urn:showtimesAPI#fetchExperiences');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
@$server->service(file_get_contents("php://input"));

function fetchMovies() {
    $con = BookingConnection::getInstance();
    return $con->getMovies();
}

function fetchCinemas() {
    $con = BookingConnection::getInstance();
    return $con->getCinemas();
}

function fetchExperiences() {
    $con = BookingConnection::getInstance();
    return $con->getExperiences();
}

function fetchShowTime($movieId, $date, $cinemaId, $experience) {
    $con = BookingConnection::getInstance();

    if (isset($date) && !empty($date)) {
        if (isset($cinemaId) && !empty($cinemaId)) {
            if (isset($experience) && !empty($experience)) {
                return GeneralUtilities::calculatePrice($con->getShowTime($movieId, $date, $cinemaId, $experience));
            }
            return GeneralUtilities::calculatePrice($con->getShowExperiences($movieId, $date, $cinemaId, false));
        }

        if (isset($experience) && !empty($experience)) {
            return GeneralUtilities::calculatePrice($con->getShowTime($movieId, $date, "", $experience));
        }

        return GeneralUtilities::calculatePrice($con->getShowCinemas($movieId, $date, false));
    }

    if (isset($cinemaId) && !empty($cinemaId)) {
        if (isset($experience) && !empty($experience)) {
            return GeneralUtilities::calculatePrice($con->getShowTime($movieId, "", $cinemaId, $experience));
        }

        return GeneralUtilities::calculatePrice($con->getShowExperiences($movieId, "", $cinemaId, false));
    }

    if (isset($experience) && !empty($experience)) {
        return GeneralUtilities::calculatePrice($con->getShowTime($movieId, "", "", $experience));
    }

    return GeneralUtilities::calculatePrice($con->getShowDates($movieId, false));
}
