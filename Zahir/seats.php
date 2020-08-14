<?php
require_once '../Database/BookingConnection.php';

function getInHourMinuteFormat($showTime): String {
    $hours = (int) ($showTime / 60);
    $minutes = str_pad($showTime % 60, 2, '0', STR_PAD_RIGHT);
    return $hours . ":" . $minutes;
}

if (isset($_GET['id'])) {
    $db = new BookingConnection();
    $showtimeID = $_GET['id'];
    $showDetials = $db->getShowTimeDetails($showtimeID);

    /* create a dom document with encoding utf8 */
    $domtree = new DOMDocument('1.0', 'UTF-8');
    $domtree->formatOutput = true;

    /* create the root element of the xml tree */
    $xmlShowtimes = $domtree->createElement("showtimes");
    
    /* append it to the document created */
    $xmlShowtimes = $domtree->appendChild($xmlShowtimes);

    /* Create showtime element */
    $xmlShowtime = $domtree->createElement("showtime");
    $xmlShowtime = $xmlShowtimes->appendChild($xmlShowtime);
    $xmlShowtime->appendChild($domtree->createAttribute('id'));
    $xmlShowtime->setAttribute('id', $showDetials['showtimeID']);

    /* elements inside showtime */
    $xmlShowtime->appendChild($domtree->createElement('date', $showDetials['showDate']));
    $xmlShowtime->appendChild($domtree->createElement('time', getInHourMinuteFormat($showDetials['showTime'])));
    $xmlShowtime->appendChild($xmlCinema = $domtree->createElement('cinema'));
    $xmlShowtime->appendChild($xmlMovie = $domtree->createElement('movie'));
    
    /* elements inside cinema */
    $xmlCinema->appendChild($domtree->createAttribute('id'));
    $xmlCinema->appendChild($domtree->createElement('name', "TGX Wangsa Walk"));
    
    /* elements inside movie */
    $xmlMovie->appendChild($domtree->createElement('name', "Avengers"));
    
    /* get the xml printed */
    echo $domtree->save("showtime.xml");
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
// put your code here
        ?>
    </body>
</html>
