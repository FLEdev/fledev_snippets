<?php

namespace Helper;

final class UserHelper{


    public function __construct()
    {

    }

    /**
     * @return bool
     */
    public static function checkLogin(string $email, string $password) :bool
    {
        if(isset($_SESSION['user_id'])) {
            session_regenerate_id();
            return $_SESSION['user_id'];
            $returnValue = true;
        } else {

            session_start();

            // check here valid Username
            $userID = 1;

            session_regenerate_id();
            $_SESSION = array();
            $_SESSION['user_id'] = $userID;
            $returnValue = true;
        }
        return $returnValue;
    }

    public static function getUserLogin() :int
    {
        // Since we are not checking with DB Session, we start the session manually
        session_start();
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    }

    public static function logoutUser() {

    }
}