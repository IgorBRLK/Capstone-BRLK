<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// used anywhere we submit our data same with the session
//generate a token and check if it exists so another user can not do CSRF
class Token {
    // generate a new token and return the Session put and token and put into the session
    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    // get token and see if it is the same as the token with the session
    public static function check($token) {
        // get the token name
        $tokenName = Config::get('session/token_name');

        // If the session exists and the token that was applied to the token then delete (generated uniquely)
        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }

}
?>