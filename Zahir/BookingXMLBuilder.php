<?php

/**
 * Description of BookingXMLBuilder
 *
 * @author Zahir
 */
class BookingXMLBuilder {

    public function __construct($filename) {
        $this->readFromXML($filename);
        $this->display();
    }

}
