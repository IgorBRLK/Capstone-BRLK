<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// this is just for security we can choose any way we want to(What this does is takes the user password puts some salt on it and makes it into a hash)
class Hash {
    // make the hash
    public static function make($string, $salt = '') {
        // return a hash with string and concatinat the salt
        return hash('sha256', $string . $salt);
    }
    // create a salt
    public static function salt($length) {
        // return salt which is random
        return mcrypt_create_iv($length);
    }
    // make a unique hash for every user
    public static function unique() {
        // return itself and making it uniqui
        return self::make(uniqid());
    }

}

/*
 * example password is password but
 * password+(salt=2546ou) = hash of oi5oeui65o
 * again password but password+(salt=eui56) = hash of ueiueueu41541
 */

?>
