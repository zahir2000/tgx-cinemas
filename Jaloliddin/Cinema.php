<?php
require_once 'CinemaConnection.php';
require_once 'CinemaXML.php';

session_start();

if (!isset($_SESSION["username"])) {
    header('Location:/tgx-cinemas/Jaloliddin/Admin/Client.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinema Locations</title>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    </head>
    <body>
        <?php include ('Utilities/navigation.php'); ?>
        <?php
        //database instance
        $cinemaCon = new CinemaConnection();
        //get cinema details result from query
        $cinemaDetails = $cinemaCon->getCinemaDetails();

        //create cinema xml class 
        $cinemaXML = new CinemaXML($cinemaDetails);

        //load xml file
        $xmlDoc = new DOMDocument();
        $xmlDoc->load('Cinema.xml');
        
        //load xsl stylesheet
        $xsl = new DOMDocument();
        $xsl->load('Cinema.xsl');
        $proc = new XSLTProcessor();
        $proc->registerPHPFunctions();
        
        //makes use of the stylesheet
        $proc->importStylesheet($xsl);

        echo $proc->transformToXml($xmlDoc);
        ?>
    </body>
</html>
