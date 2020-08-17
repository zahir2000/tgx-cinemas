<?php

class ShowtimeXSLT {
    private $xml = "Showtime.xml";
    private $xsl = "Showtime.xsl";

    public function __construct($showtimeId) {
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
