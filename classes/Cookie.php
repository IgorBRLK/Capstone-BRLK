<?php
// Cookie 
class Cookie {
    // check if a cookie exist
    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }
    // get the value of the cookie
    public static function get($name) {
        return $_COOKIE[$name];
    }
    // creates a cookie with a name value and expiry
    public static function put($name, $value, $expiry) {
        // set a cookie (you can look of setcookie)
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }
    // cookie is not deleted but reset with a negative number, null, or empty stirng
    public static function delete($name) {
        // to delete the cookie we set a name value of nothing and so on
        self::put($name, '', time() - 1);
    }

}
