<?php
class DatabaseConnection {
    private static $instance;
    private $db;
    
    private function __construct() 
    {
        $host = 'localhost';
        $dbName = 'tgx_db';
        $user = 'root';
        $password = '';

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
    
    public function closeConnection(){
        $this->db = null;
    }
}
