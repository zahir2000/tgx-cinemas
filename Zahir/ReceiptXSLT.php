<?php

/**
 * @author Zahiriddin Rustamov
 */
class ReceiptXSLT {

    private $xml;
    private $xsl = "Receipt.xsl";

    public function __construct($userId) {
        $this->xml = "Booking/Booking" . $userId . ".xml";
        $this->generateTicket();
    }

    private function generateTicket() {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($this->xml);

        $xsl = new DOMDocument();
        $xsl->load($this->xsl);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        //$proc->setParameter('', 'showtimeID', $showtimeId);

        echo $proc->transformToXml($xmlDoc);
    }

}
