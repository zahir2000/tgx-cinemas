<?php
class DatabaseConnection {
    private static $instance;
    private $db;
    
    private function __construct() 
    {
        $host = 'localhost';
        $dbName = 'tgx_db';
        $user = 'root';
        $password = '11234566z';

        // set up DSN
        $dsn = "mysql:host=$host;dbname=$dbName";

        try {
            $this->db = new PDO($dsn, $user, $password);
            //echo "<p>Connection to database successful</p>";
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit;
        }
    }
    
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }
    
    public function getDb(){
        if ($this->db instanceof PDO) {
            return $this->db;
       }
    }
    
    public function getMovieDetails($movieID){
        $query = "SELECT * FROM Movie WHERE movieid = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $movieID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        else{
            return null;
        }
    }
    
    public function closeConnection(){
        $this->db = null;
    }
}
