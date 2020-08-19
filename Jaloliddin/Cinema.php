<?php
require_once 'CinemaConnection.php';
require_once 'CinemaXML.php';
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //get cinema details $cinemaDetails = result from query

        $cinemaCon = new CinemaConnection();
        $cinemaDetails = $cinemaCon->getCinemaDetails();
        //create cinema xml class 
        $cinemaXML = new CinemaXML($cinemaDetails);

        $xmlDoc = new DOMDocument();
        $xmlDoc->load('Cinema.xml');

        $xsl = new DOMDocument();
        $xsl->load('Cinema.xsl');

        $proc = new XSLTProcessor();
        $proc->registerPHPFunctions();
        $proc->importStylesheet($xsl);

        echo $proc->transformToXml($xmlDoc);
        ?>
    </body>
</html>
