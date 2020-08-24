<?php

/**
 * @author Zahiriddin Rustamov
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';

class BookingConnection {

    private $db;
    private static $instance;

    private function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new BookingConnection();
        }
        return self::$instance;
    }

    public function getMovies() {
        $query = "SELECT DISTINCT M.name as movieName, M.movieID, poster, synopsis FROM movie M, showtime S where S.movieID = M.movieID AND showDate >= CURDATE() ORDER BY 1";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $movies = NULL;
        }

        return $movies;
    }

    public function getCinemas() {
        $query = "SELECT DISTINCT name as cinemaName, cinemaID FROM cinema ORDER BY 1";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $cinemas = NULL;
        }

        return $cinemas;
    }

    public function getExperiences() {
        $query = "SELECT DISTINCT experience FROM hall ORDER BY 1";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getShowDates($movieId, $distinct = true) {
        //$queryDate = "SELECT DISTINCT showDate FROM showtime WHERE movieid = ? ORDER BY showDate";
        $query = "SELECT DISTINCT showDate "
                . "FROM showtime "
                . "WHERE movieid = ? "
                . "ORDER BY showDate";

        /* If we specify DISTINCT statement, only a single column can be specified
         * In some cases we may need to get other information as well */
        if (!$distinct) {
            $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, basePrice "
                    . "FROM showtime S, movie M, hall H, cinema C "
                    . "WHERE S.movieID = ? AND showDate >= CURDATE()  AND S.movieID = M.movieID AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID "
                    . "ORDER BY C.name, S.showDate, S.showTime";
        }

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $movieId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getShowCinemas($movieId, $date, $distinct = true) {
        $cinemaQuery = "SELECT DISTINCT C.cinemaID, C.name "
                . "FROM showtime S, hall H, cinema C "
                . "WHERE movieid = ? AND showDate = ? AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID";

        if (!$distinct) {
            $cinemaQuery = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, basePrice "
                    . "FROM showtime S, hall H, cinema C "
                    . "WHERE movieid = ? AND showDate = ? AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID "
                    . "ORDER BY C.name, S.showDate, S.showTime";
        }

        $cinemaStmt = $this->db->getDb()->prepare($cinemaQuery);
        $cinemaStmt->bindParam(1, $movieId, PDO::PARAM_INT);
        $cinemaStmt->bindParam(2, $date);
        $cinemaStmt->execute();

        if ($cinemaStmt->rowCount() != 0) {
            $cinemas = $cinemaStmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $cinemas = NULL;
        }

        return $cinemas;
    }

    public function getShowExperiences($movieId, $date, $cinemaId, $distinct = true) {
        $query = "SELECT DISTINCT experience "
                . "FROM showtime S, hall H, cinema C "
                . "WHERE movieid = :movieId AND showDate = :date AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID AND C.cinemaID = :cinemaId "
                . "ORDER BY C.name, S.showDate, S.showTime";

        if (!$distinct) {
            $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, basePrice "
                    . "FROM showtime S, hall H, cinema C "
                    . "WHERE movieid = :movieId AND showDate = :date AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID AND C.cinemaID = :cinemaId "
                    . "ORDER BY C.name, S.showDate, S.showTime";

            if (empty($date)) {
                $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, basePrice "
                        . "FROM showtime S, hall H, cinema C "
                        . "WHERE movieid = :movieId AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.cinemaID = C.cinemaID AND C.cinemaID = :cinemaId "
                        . "ORDER BY C.name, S.showDate, S.showTime";
            }
        }

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        if (!empty($date)) {
            $stmt->bindParam(':date', $date);
        }
        $stmt->bindParam(':cinemaId', $cinemaId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getShowTime($movieId, $date, $cinemaId, $experience) {
        $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, showtimeID, basePrice "
                . "FROM showtime S, hall H, cinema C "
                . "WHERE movieid = :movieId AND showDate = :date AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.experience = :exp AND H.cinemaID = C.cinemaID AND C.cinemaID = :cinemaId "
                . "ORDER BY C.name, S.showDate, S.showTime";

        if (empty($cinemaId)) {
            $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, showtimeID, basePrice "
                    . "FROM showtime S, hall H, cinema C "
                    . "WHERE movieid = :movieId AND showDate = :date AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.experience = :exp AND H.cinemaID = C.cinemaID "
                    . "ORDER BY C.name, S.showDate, S.showTime";
        }

        if (empty($date)) {
            $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, showtimeID, basePrice "
                    . "FROM showtime S, hall H, cinema C "
                    . "WHERE movieid = :movieId AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.experience = :exp AND H.cinemaID = C.cinemaID AND C.cinemaID = :cinemaId "
                    . "ORDER BY C.name, S.showDate, S.showTime";

            if (empty($cinemaId)) {
                $query = "SELECT S.showTime, S.showDate, C.name as cinemaName, H.hallID, H.experience, showtimeID, basePrice "
                        . "FROM showtime S, hall H, cinema C "
                        . "WHERE movieid = :movieId AND showDate >= CURDATE() AND S.hallID = H.hallID AND H.experience = :exp AND H.cinemaID = C.cinemaID "
                        . "ORDER BY C.name, S.showDate, S.showTime";
            }
        }

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        if (!empty($date)) {
            $stmt->bindParam(':date', $date);
        }
        $stmt->bindParam(':exp', $experience);
        if (!empty($cinemaId)) {
            $stmt->bindParam(':cinemaId', $cinemaId, PDO::PARAM_INT);
        }
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getShowTimeDetails($showtimeID) {
        $query = "SELECT showtimeID, showDate, showTime, S.hallID, S.movieID, H.experience, H.cinemaID, C.name as cinemaName, M.name as movieName, M.ageRestriction, basePrice "
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

    public function getBookedSeats($showtimeId) {
        $query = "SELECT seat "
                . "FROM ticket "
                . "WHERE showtimeID = ? ";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $showtimeId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function storeToDatabase($booking, $cart) {
        $bookingId = $this->storeBookingDetails($booking);
        $this->storeTicketDetails($bookingId, $cart);
    }

    private function storeBookingDetails($booking) {
        $query = "INSERT INTO booking VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->getDb()->prepare($query);

        $id = null;
        $date = $booking->getDate();
        $adultCount = $booking->getNoOfAdults();
        $kidCount = $booking->getNoOfKids();
        $method = $booking->getPaymentMethod();
        $credentials = $booking->getCredentials();
        $totalPrice = $booking->getTotalPrice();
        $userId = $booking->getUser()->getUserId();

        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $date);
        $stmt->bindParam(3, $adultCount, PDO::PARAM_INT);
        $stmt->bindParam(4, $kidCount, PDO::PARAM_INT);
        $stmt->bindParam(5, $method, PDO::PARAM_STR);
        $stmt->bindParam(6, $credentials, PDO::PARAM_STR);
        $stmt->bindParam(7, $totalPrice);
        $stmt->bindParam(8, $userId, PDO::PARAM_INT);

        $stmt->execute();
        $bookingId = $this->db->getLastInsertId();

        return $bookingId;
    }

    private function storeTicketDetails($bookingId, $cart) {
        $query = "INSERT INTO ticket VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->getDb()->prepare($query);

        $id = null;
        $showtimeId = $cart->getShowtimeId();

        $cartTickets = $cart->getTickets();

        foreach ($cartTickets as $ticket) {
            $price = $ticket->cost();
            $seat = $ticket->getSeat();
            $type = $ticket->getType()->type();

            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $seat, PDO::PARAM_STR);
            $stmt->bindParam(4, $type, PDO::PARAM_STR);
            $stmt->bindParam(5, $showtimeId, PDO::PARAM_INT);
            $stmt->bindParam(6, $bookingId, PDO::PARAM_INT);

            $stmt->execute();
        }
    }

    public function getUserToken($username) {
        $query = "SELECT token FROM usertoken WHERE username = ?";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = null;
        }
        
        return $result;
    }

    public function updateToken($username, $userToken) {
        $tokenQuery = "SELECT * FROM usertoken WHERE username = ?";
        $stmt = $this->db->getDb()->prepare($tokenQuery);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $updateToken = "UPDATE usertoken SET token = ? WHERE username = ?";
            $stmt = $this->db->getDb()->prepare($updateToken);
            $stmt->bindParam(1, $userToken, PDO::PARAM_STR);
            $stmt->bindParam(2, $username, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $updateToken = "INSERT INTO usertoken(username, token) VALUES (?, ?)";
            $stmt = $this->db->getDb()->prepare($updateToken);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $userToken, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

}
