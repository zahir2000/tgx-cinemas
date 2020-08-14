<?php
require_once '../Database/BookingConnection.php';
require_once 'ShowtimeXMLBuilder.php';
require_once 'ShowtimeXPath.php';

function getInHourMinuteFormat($showTime): String {
    $hours = (int) ($showTime / 60);
    $minutes = str_pad($showTime % 60, 2, '0', STR_PAD_RIGHT);
    return $hours . ":" . $minutes;
}

if (isset($_GET['id'])) {
    $db = new BookingConnection();
    $showtimeID = $_GET['id'];
    $showtimeDetails = $db->getShowTimeDetails($showtimeID);

    $xml = new ShowtimeXMLBuilder();
    $xml->append($showtimeDetails);
    
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("showtime.xml");
    
    $xsl = new DOMDocument();
    $xsl->load("seats.xsl");
    
    $proc = new XSLTProcessor();
    $proc->importStylesheet($xsl);
    
    echo $proc->transformToXml($xmlDoc);
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
