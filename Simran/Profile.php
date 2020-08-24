<?php
//require all the required files that needs to be accessed
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/CheckLogin.php';
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
        
        //assign userconnection to profileDb
        $profileDb = UserConnection::getInstance();
        //assign session to profileDetails
        $profileDetails = $profileDb->getUserDetails(SessionHelper::get('userId'));
        
        //create a ProfileXML file with profileDetails
        $profileXML = new ProfileXML($profileDetails);
        
        //initialize DOMDocument into docXML
        $docXML = new DOMDocument();
        //load Profile.xml
        $docXML->load('Profile.xml');
        
        //initialize DOMDocument into docXSL
        $docXSL = new DOMDocument();
        //load Profile.xsl
        $docXSL->load('Profile.xsl');
        
        //initialize XSLTProcessor into process
        $process = new XSLTProcessor();
        //register functions
        $process->registerPHPFunctions();
        //import the stylesheet from docXSL which is from Profile.xsl
        $process->importStylesheet($docXSL);
        
        //generate Profile.xml with the data retrieved in it
        echo $process->transformToXml($docXML);
        ?>
    </body>
</html>
