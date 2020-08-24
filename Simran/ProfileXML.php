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
    
    //assign Profile.xml to a variable
    private $xmlFile = "Profile.xml";
    
    public function __construct($profileDetails) {
        //create an xml file
        $this->createXML();
        //append profileDetails
        $this->append($profileDetails);
    }
    
    private function append($profileDetails){
        //initializing an xpath to xmlfile
        $xpath = new ProfileXPath($this->xmlFile);
        
        //checks the userID in profileDetails, if it does not match, creates an Element
        if(!$xpath->checkID($profileDetails['userID'])){
            $this->createElement($profileDetails);
        }
    }
    
    private function createElement($profileDetails){
        //a new DOMDoc assigned to domtree
        $domtree = new DOMDocument('1.0', 'UTF-8');
        //format the output to true
        $domtree->formatOutput = true;
        //load the xml file, with no blanks
        $domtree->loadXML(file_get_contents($this->xmlFile), LIBXML_NOBLANKS);
        //get the tagline 'users' and assign as root
        $root = $domtree->getElementsByTagName('users')->item(0);
        
        //create an element with user
        $xmlProfile = $domtree->createElement("user");
        //append xmlProfile
        $xmlProfile = $root->appendChild($xmlProfile);
        
        //create an id attribute
        $xmlProfile->appendChild($domtree->createAttribute('id'));
        //set the attribute to the userID of profileDetails
        $xmlProfile->setAttribute('id', $profileDetails['userID']);
        //create elements for all the details retreived. Name, emai, number, dob, gender, address.
        $xmlProfile->appendChild($domtree->createElement('name', $profileDetails['name']));
        $xmlProfile->appendChild($domtree->createElement('email', $profileDetails['email']));
        $xmlProfile->appendChild($domtree->createElement('number', $profileDetails['number']));
        $xmlProfile->appendChild($domtree->createElement('dob', $profileDetails['dob']));
        $xmlProfile->appendChild($domtree->createElement('gender', $profileDetails['gender']));
        $xmlProfile->appendChild($domtree->createElement('address', $profileDetails['address']));
        
        //save all the data into xmlFile
        $domtree->save($this->xmlFile);
    }
    
    private function createXML() {
        //a new DOMDoc assigned to domtree
        $domtree = new DOMDocument('1.0', 'UTF-8');
        //format the output to true
        $domtree->formatOutput = true;
        
        //create an Element user
        $xmlProfile = $domtree->createElement("users");
        //append xmlProfile
        $xmlProfile = $domtree->appendChild($xmlProfile);
        //save the xmlFile
        $domtree->save($this->xmlFile);
    }
}
