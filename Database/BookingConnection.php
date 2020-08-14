<?php

/**
 * @author Zahiriddin Rustamov
 */
require_once 'DatabaseConnection.php';

class BookingConnection {

    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public function getShowTimeDetails($showtimeID) {
        $query = "SELECT showtimeID, showDate, showTime, S.hallID, S.movieID, H.experience,  FROM Showtime S,  "
                . "WHERE showtimeID = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $showtimeID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

}
