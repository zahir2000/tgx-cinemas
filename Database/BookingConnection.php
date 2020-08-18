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
        $query = "SELECT showtimeID, showDate, showTime, S.hallID, S.movieID, H.experience, H.cinemaID, C.name as cinemaName, M.name as movieName, M.ageRestriction "
                . "FROM showtime S, movie M, cinema C, hall H "
                . "WHERE showtimeID = ? AND S.movieID = M.movieID AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID";
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

    public function getMovieDetails($movieID) {
        $query = "SELECT * FROM movie WHERE movieid = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $movieID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

}
