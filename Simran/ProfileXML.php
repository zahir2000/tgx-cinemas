<?php
require_once 'ProfileXPath.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileXML
 *
 * @author Harrsimran Kaur
 */
class ProfileXML {
    
    private $xmlFile = "Profile.xml";
    
    public function __construct($profileDetails) {
        $this->createXML();
        $this->append($profileDetails);
    }
    
    private function append($profileDetails){
        $xpath = new ProfileXPath($this->xmlFile);
        
        if(!$xpath->checkID($profileDetails['userID'])){
            $this->createElement($profileDetails);
        }
    }
    
    private function createElement($profileDetails){
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        $domtree->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        $root = $domtree->getElementsByTagName('users')->item(0);
        
        $xmlProfile = $domtree->createElement("user");
        $xmlProfile = $root->appendChild($xmlProfile);
        
        $xmlProfile->appendChild($domtree->createAttribute('id'));
        $xmlProfile->setAttribute('id', $profileDetails['userID']);
        $xmlProfile->appendChild($domtree->createElement('name', $profileDetails['name']));
        $xmlProfile->appendChild($domtree->createElement('email', $profileDetails['email']));
        $xmlProfile->appendChild($domtree->createElement('number', $profileDetails['number']));
        $xmlProfile->appendChild($domtree->createElement('dob', $profileDetails['dob']));
        $xmlProfile->appendChild($domtree->createElement('gender', $profileDetails['gender']));
        $xmlProfile->appendChild($domtree->createElement('address', $profileDetails['address']));
        
        $domtree->save($this->xmlFile);
    }
    
    private function createXML() {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $domtree->formatOutput = true;
        
        $xmlProfile = $domtree->createElement("users");
        $xmlProfile = $domtree->appendChild($xmlProfile);
        $domtree->save($this->xmlFile);
    }
    
    private function readFromXML($xmlFile) {
        $xml = @file_get_contents($xmlFile);
        
        if(trim($xml) == ''){
            $this->createXML();
        }
    }

    
}
