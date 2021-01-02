<?php

class user {
    private $email;
    private $ID;

    function __construct($email) {
        $this->ID = 0;
        $this->email = $email;
    }

    public function userExists() {
        $result = false;
        $dbconn = new db();
        $user = $dbconn->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);
 
        if ($user) {
            $result = true;
        }
        
        return $result;
    }


    public function userLogin() {
        $dbconn = new db();
        $user = $dbconn->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);

        if ($user) {
            $this->ID = $user["ID"];
        }

        $_SESSION["userID"] = $this->ID;
    }

    public function registerUser() {
        $dbconn = new db();
        $dbconn->insertInto("`users` (`ID`, `email`) VALUES (NULL, :email)", array(":email" => $this->email));
    }

    public static function userSignOut() {
        unset($_SESSION["userID"]);
    }
}