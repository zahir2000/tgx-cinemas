<?php

/**
 * Description of MovieXPath
 *
 * @author: Venessa Choo Wei Ling
 */
class MovieXPath {
    private $xpath;

    public function __construct($xmlFilePath) {
        $doc = new DOMDocument();
        $doc->load($xmlFilePath);
        $this->xpath = new DOMXPath($doc);
    }

    public function checkID($movieID) {
        $expr = ('//movie[@movieID=' . $movieID . ']');
        $exists = $this->xpath->query($expr);

        if ($exists->length > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMovieDetailById($movieID) {
        $expr = ('/movies/movie[@movieID=' . $movieID . ']');
        $result = $this->xpath->query($expr);

        if ($result->length < 1) {
            die('....no such element');
        } else {
            foreach ($result as $item) {
                // echo $item->nodeValue . "<br />";

                foreach ($item->getElementsByTagName('name') as $element) {
                    echo $element->nodeValue;
                }
            }
        }
    }
}
