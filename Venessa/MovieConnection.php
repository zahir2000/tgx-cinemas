<?php

require $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';
require $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Venessa/Classes/Movie.php';

/**
 * Description of MovieConnection
 *
 * @author Venessa Choo Wei Ling
 */
class MovieConnection {

    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public function getAllMovieForXML() {
        $query = "SELECT * FROM movie ORDER BY name ASC ";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

    public function getAllMovieForWeb() {
        $movieList = array();
        $query = "SELECT * FROM movie ORDER BY name ASC ";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $m) {
                $movie = new Movie($m['movieID'], $m['name'], $m['poster'], $m['length'], $m['status'], $m['genre'], $m['language'], $m['subtitle'], $m['ageRestriction'], $m['releaseDate'], $m['cast'], $m['director'], $m['distributor'], $m['synopsis']);
                $movieList[] = $movie;
            }
            return $movieList;
        } else {
            return null;
        }
    }

    public function getSearchedMovieForXML($movieName) {
        $movieName = "%" . $movieName . "%";
        $query = "SELECT * FROM movie WHERE name LIKE ? ORDER BY name ASC ";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $movieName, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

    public function getSearchedMovieForWeb($movieName) {
        $movieList = array();
        $movieName = "%" . $movieName . "%";
        $query = "SELECT * FROM movie WHERE name LIKE ? ORDER BY name ASC ";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $movieName, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $m) {
                $movie = new Movie($m['movieID'], $m['name'], $m['poster'], $m['length'], $m['status'], $m['genre'], $m['language'], $m['subtitle'], $m['ageRestriction'], $m['releaseDate'], $m['cast'], $m['director'], $m['distributor'], $m['synopsis']);
                $movieList[] = $movie;
            }
            return $movieList;
        } else {
            return null;
        }
    }

    public function getReleaseDateOfMovie($movieName) {
        $query = "SELECT * FROM movie WHERE name = ? LIMIT 1";

        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(1, $movieName, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $releaseDate = $result['releaseDate'];
            return $releaseDate;
        } else {
            return null;
        }
    }

}
