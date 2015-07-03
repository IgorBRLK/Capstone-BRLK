<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// session class to use sessions
class Session {

    // check if a session exists check a name and return if the token is set true else false
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }
    // session name and session name return the value of the session
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }
    // get the session name
    public static function get($name) {
        return $_SESSION[$name];
    }
    // if exists unset the session name (unset if exists)
    public static function delete($name) {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    // flash data means flash messege and next time they reload it it will not show. Maybe we can use this for the Guest
    public static function flash($name, $string = '') {
        // check if session exists
        if (self::exists($name)) {
            // create a message
            $session = self::get($name);
            // delete the message 
            self::delete($name);
            return $session;
        } else {
            // otherwise set the data
            self::put($name, $string);
        }

    }

}
?>