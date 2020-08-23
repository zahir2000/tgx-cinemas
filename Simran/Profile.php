<?php
require_once '../Database/UserConnection.php';
require_once 'ProfileXML.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
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
        $profileDetails = $profileDb->getUserDetails(SessionHelper::get('userId'));
        
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
