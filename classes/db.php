<?php

class db {
    private static $options;
    private static $host;
    private static $dbname;
    private static $charset;
    private static $dbuser;
    private static $dbpass;
    private static $dsn;
    private $pdo;
    private $stmt;
    private $lastId;

    function __construct() {
        self::$options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]; 

        self::getDBSettings();
    }

    private static function getDBSettings() {
        $settings = json_decode(file_get_contents("./config/app.json"), true);
    
        self::$host = $settings["db"]["host"];
        self::$dbname = $settings["db"]["dbname"];
        self::$charset = $settings["db"]["charset"];
        self::$dbuser = $settings["db"]["dbuser"];
        self::$dbpass = $settings["db"]["dbpass"];
        self::$dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset . ";";  
    }

    private function connect() {
        $this->pdo = new PDO(self::$dsn, self::$dbuser, self::$dbpass, self::$options);
    }

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

    public function getLastId() :int {
        return $this->lastId;
    }

    public function get($query, $data, $fetchAll = true) {
        try {
            $result;

            $this->execute("SELECT " . $query, $data);

            if ($fetchAll) {
                $result = $this->stmt->fetchAll();
            }
            else {
                $result = $this->stmt->fetch();
            }

            
            return $result;
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
    }

    public function insertInto($query, $data) {
        try {
            $this->execute("INSERT INTO " . $query, $data);
            $this->lastId = $this->pdo->lastInsertId();
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
    }

    public function update($query, $data) {
        try {
            $this->execute("UPDATE " . $query, $data);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete($query, $data) {
        try {
            $this->execute("DELETE FROM " . $query, $data);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}