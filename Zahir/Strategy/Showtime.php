<?php

/**
 * Description of Showtime
 *
 * @author Zahir
 */
class Showtime {

    private $date;
    private $time;
    private $hall;
    private $movie;

    function __construct($date="", $time="", $hall="", $movie="") {
        $this->date = $date;
        $this->time = $time;
        $this->hall = $hall;
        $this->movie = $movie;
    }

}
