<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/WeiLing/Classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/WeiLing/FactoryMethod/FileLoggerFactory.php';

/**
 * Description of MovieConnection
 *
 * @author Venessa Choo Wei Ling
 */
class MovieConnection {

    private $db;
    private $loggerFactory = null;
    private $logger = null;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance();

        $this->loggerFactory = new FileLoggerFactory();
        $this->logger = $this->loggerFactory->createLogger();
    }

    public function getAllMovieForXML() {
        $this->logger->log("Get all movies from DB for Movie.xml");

        try {
            $query = "SELECT * FROM movie ORDER BY name ASC ";
            $stmt = $this->db->getDb()->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            $this->logger->log("Fail to getAllMovieForXML: " . $ex->getMessage());
            return null;
        }
    }

    public function getAllMovieForWeb() {
        $this->logger->log("Get all movies from DB to display in web");
        $movieList = array();

        try {
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
        } catch (Exception $ex) {
            $this->logger->log("Fail to getAllMovieForWeb: " . $ex->getMessage());
            return null;
        }
    }

    public function getSearchedMovieForXML($movieName) {
        $this->logger->log("Get searched movies from DB for Movie.xml");
        $movieName = "%" . $movieName . "%";

        try {
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
        } catch (Exception $ex) {
            $this->logger->log("Fail to getSearchedMovieForXML: " . $ex->getMessage());
            return null;
        }
    }

    public function getSearchedMovieForWeb($movieName) {
        $this->logger->log("Get searched movies from DB to display in web");
        $movieList = array();
        $movieName = "%" . $movieName . "%";

        try {
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
        } catch (Exception $ex) {
            $this->logger->log("Fail to getSearchedMovieForWeb: " . $ex->getMessage());
            return null;
        }
    }

    public function getReleaseDateOfMovie($movieName) {
        $this->logger->log("Get release date of searched movie from DB");

        try {
            $query = "SELECT * FROM movie WHERE name = ? LIMIT 1";

            $stmt = $this->db->getDb()->prepare($query);
            $stmt->bindParam(1, $movieName, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $releaseDate = $result['releaseDate'];
                $this->logger->log("Movie search: " . $movieName . ", Release Date: " . $releaseDate);
                return $releaseDate;
            } else {
                $this->logger->log("No movie found for: " . $movieName);
                return null;
            }
        } catch (Exception $ex) {
            $this->logger->log("Fail to getReleaseDateOfMovie: " . $ex->getMessage());
            return null;
        }
    }

}
