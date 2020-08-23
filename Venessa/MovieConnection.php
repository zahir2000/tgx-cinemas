<?php
require $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';

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

    public function getAllMovie() {
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

    public function getSearchedMovie($movieName) {
        $movieName = "%".$movieName."%";
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
