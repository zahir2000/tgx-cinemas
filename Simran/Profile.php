<?php
require_once '../Database/UserConnection.php';
require_once 'ProfileXML.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $profileDb = UserConnection::getInstance();
        $profileDetails = $profileDb->getUserDetails();
        
        $profileXML = new ProfileXML($profileDetails);
        
        $docXML = new DOMDocument();
        $docXML->load('Profile.xml');
        
        $docXSL = new DOMDocument();
        $docXSL->load('Profile.xsl');
        
        $process = new XSLTProcessor();
        $process->registerPHPFunctions();
        $process->importStylesheet($docXSL);
        
        echo $process->transformToXml($docXML);
        ?>
    </body>
</html>
