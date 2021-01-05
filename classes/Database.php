<?php

/*
This class handles the connection to the database. DB settings is retrieved from the conf file in /config/app.json.

There are predefined methods for CRUD (Create, Read, Update and Delete).

Get the last inserted ID with method getLastId().
*/

class Database {
    //Some properties is static because they should be the same during runtime
    private static $options;
    private static $host;
    private static $charset;
    private static $dbName;
    private static $dbUser;
    private static $dbPass;
    private static $dsn;
    private $pdo;
    private $stmt;
    private $lastId;

    //PDO options which is set on first call of the class
    public function __construct() {
        self::$options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]; 

        //Get settings from the conf file
        self::getDBSettings();
    }

    //Assign each Json key to the settings array and assign to respective class property.
    private static function getDBSettings() {
        $settings = json_decode(file_get_contents("./config/app.json"), true);
    
        self::$host = $settings["db"]["host"];
        self::$dbName = $settings["db"]["dbname"];
        self::$charset = $settings["db"]["charset"];
        self::$dbUser = $settings["db"]["dbuser"];
        self::$dbPass = $settings["db"]["dbpass"];
        self::$dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=" . self::$charset . ";";  
    }

    //Creates a new pdo instance
    private function connect() {
        $this->pdo = new PDO(self::$dsn, self::$dbUser, self::$dbPass, self::$options);
    }

    //This method connects and execute the provided query and data
    private function execute($query, $data = null) {
        $this->connect();
        $this->stmt = $this->pdo->prepare($query);

        if (isset($data)) {
            $this->stmt->execute($data);
        }
        else {
            $this->stmt->execute();
        }
    }

    //Get last inserted id
    public function getLastId() :int {
        return $this->lastId;
    }

    //Makes a select query (read/get data)
    public function get($query, $data, $fetchAll = true) :array {
        try {
            $result = array();

            $this->execute("SELECT " . $query, $data);

            if ($fetchAll) {
                $result = $this->stmt->fetchAll();
            }
            else {
                $result = $this->stmt->fetch();
            }

            if (!$result) {
                $result = array();
            }

            return $result;
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
    }

    //Makes a insert query (add data) and updates the lastID property
    public function insertInto($query, $data) {
        try {
            $this->execute("INSERT INTO " . $query, $data);
            $this->lastId = $this->pdo->lastInsertId();
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
    }

    //Makes a update
    public function update($query, $data) {
        try {
            $this->execute("UPDATE " . $query, $data);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    //Delete query
    public function delete($query, $data) {
        try {
            $this->execute("DELETE FROM " . $query, $data);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}