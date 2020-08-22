<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileXPath
 *
 * @author Harrsimran Kaur
 */
class ProfileXPath {
    
    private $xpath;
    
    public function __construct($filename) {
        $doc = new DOMDocument();
        $doc->load($filename);
        $this->xpath = new DOMXPath($doc);
    }
    
    public function checkID($userID) {
        $expr = ('//user[@id=' . $userID . ']');
        $exists = $this->xpath->query($expr);
        
        if ($exists->length > 0) {
            return true;
        }else {
            return false;
        }
    }
    
    public function getUserDetails($userID) {
        $expr = ('//user/user[@id=' . $userID . ']');
        $result = $this->xpath->query($expr);
        
        foreach ($result as $item) {
            echo $item->nodeValue . "<br/>";
            
            foreach ($item->getElementsByTagName('date') as $a) {
                echo $a->nodeValue;
            }
        }
    }
}
