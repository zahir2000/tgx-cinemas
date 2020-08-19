<?php

class ShowtimeXSLT {
    private $xml;
    private $xsl = "Showtime.xsl";

    public function __construct($showtimeId, $xml = "") {
        if(empty($xml))
            $this->xml = "Showtime.xml";
        else
            $this->xml = $xml;
        
        $this->generateMovieDetails($showtimeId);
    }

    private function generateMovieDetails($showtimeId) {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($this->xml);

        $xsl = new DOMDocument();
        $xsl->load($this->xsl);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $proc->setParameter('', 'showtimeID', $showtimeId);

        echo $proc->transformToXml($xmlDoc);
    }

}
