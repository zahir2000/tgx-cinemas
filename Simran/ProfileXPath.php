<?php
/**
 * Description of ProfileXPath
 *
 * @author Harrsimran Kaur
 */
class ProfileXPath {
    
    //create a private xpath variable
    private $xpath; 
    
    public function __construct($filename) {
        //create a new DOMDocument
        $doc = new DOMDocument();
        //load filename
        $doc->load($filename);
        //putting the DOMDoc loaded with filename into a DOMXPath
        $this->xpath = new DOMXPath($doc);
    }
    
    public function checkID($userID) {
        //create an expression
        $expr = ('//user[@id=' . $userID . ']');
        //initialize the expression in a query to check if it exists.
        $exists = $this->xpath->query($expr);
        
        //checks if the expression exists or not
        if ($exists->length > 0) {
            return true;
        }else {
            return false;
        }
    }
    
    public function getUserDetails($userID) {
        //create an expression
        $expr = ('//user/user[@id=' . $userID . ']');
        //initialize the expression in a query to get the result
        $result = $this->xpath->query($expr);
        
        //checks result one by one, and then the result is assigned to item
        foreach ($result as $item) {
            echo $item->nodeValue . "<br/>";
        }
    }
}
