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

    public function getMovies() {
        $query = "SELECT M.name as movieName, M.movieID, poster, synopsis FROM movie M, showtime S where S.movieID = M.movieID AND showDate >= CURDATE() ORDER BY 1";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $movies = NULL;
        }

        return $movies;
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

}
