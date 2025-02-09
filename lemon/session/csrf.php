<?php

/*
 *
 * CSRF protection
 *
 * In this class are methods CSRF protection
 *
 * */
class CSRF
{

    /*
     *
     * Creates unique token to every user that visits any page
     *
     * Must be on start of app and requires started session 
     *
     * */
    static function setToken()
    {
        $token = uniqid();
        $token = hash("sha256", $token);
        $_SESSION["csrf_token"] = $token;
    }

    /*
     *
     * Checks if user sent post request with valid CSRF token
     *
     * To validate route, put this function on start of every route
     *
     * */
    static function check()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")    
        {
            if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]))
            {
                if ($_POST["csrf_token"] != $_SESSION["csrf_token"])
                {
                    raise(400);
                    exit();
                } 
            }
            else
            {
                raise(400);
                exit();
            }
        }
    }

    /*
     *
     * Function mainly for `@csrf` in views
     *
     * return token
     * 
     * if token is not set, throws 400
     *
     * */
    static function getToken()
    {
        if (isset($_SESSION["csrf_token"])) 
        {       
            return $_SESSION["csrf_token"];
        }
        else
        {
            raise(400);
            exit();
        }
    }
}
?>
