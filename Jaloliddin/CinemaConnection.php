<?php

require_once '../Database/DatabaseConnection.php';

/**
 * Description of Connection
 *
 * @author Jaloliddin
 */
class CinemaConnection {

    private $db;

    function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public function getCinemaDetails() {
        $query = "SELECT * FROM cinema";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

}
