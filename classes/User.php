<?php

class User {
    private $email;
    private $ID;

    public function __construct($email) {
        $this->ID = 0;
        $this->email = $email;
    }

    public function userExists() :bool {
        $result = false;
        $db = new Database();
        $user = $db->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);
 
        if ($user) {
            $result = true;
        }
        
        return $result;
    }

    public function userLogin() {
        $db = new Database();
        $user = $db->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);

        if ($user) {
            $this->ID = $user["ID"];
        }

        $_SESSION["userID"] = $this->ID;
    }

    public function registerUser() {
        $db = new Database();
        $db->insertInto("`users` (`ID`, `email`) VALUES (NULL, :email)", array(":email" => $this->email));
    }

    public static function userSignOut() {
        unset($_SESSION["userID"]);
    }
}