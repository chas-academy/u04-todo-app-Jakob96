<?php

/*
Class for user actions, like sign in / out and register. 
*/

class User {
    private $email;
    private $ID;

    public function __construct($email) {
        $this->ID = 0;
        $this->email = $email;
    }

    public function userExists() :bool {    //Check if user email exists in database
        $result = false;
        $db = new Database();

        $user = $db->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);
 
        if ($user) {
            $result = true;
        }
        
        return $result;
    }

    public function userLogin() {       //Check user email in database and set user id och email session variables to its values
        $db = new Database();
        $user = $db->get("* FROM `users` WHERE `email`=:email", array(":email" => $this->email), false);

        if ($user) {
            $this->ID = $user["ID"];
            $this->email = $user["email"];
        }

        //Assigns session variables from the user variable which then will be cleared on sign out.
        $_SESSION["userID"] = $this->ID;                  
        $_SESSION["userEmail"] = $this->email;
    }

    public function registerUser() {    //Registers a new user email
        $db = new Database();
        $db->insertInto("`users` (`ID`, `email`) VALUES (NULL, :email)", array(":email" => $this->email));
    }

    public static function userSignOut() {      //Sign out a signed in user session
        unset($_SESSION["userID"], $_SESSION["userEmail"]);
    }
}