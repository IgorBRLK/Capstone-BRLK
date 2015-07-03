<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// class that processes if the user already inputted than don't need to do it again
class Input {
    // check if exists (in other words we see if the form was submitted) Just a quick way to check if data has been submitted
    public static function exists($type = 'post') {
        // check cases of post and get we assume we always get data
        switch ($type) {
            case 'post' :
                // ternary
                return (!empty($_POST)) ? true : false;
                break;
            case 'get' :
                // ternary
                return (!empty($_GET)) ? true : false;
                break;
            default :
                return false;
                break;
        }
    }

    // which item you want to get (example $_POST['username'] insted Input::get('username')) Easy grab of post or get data from user input of form
    public static function get($item) {
        // checking for post data
        if (isset($_POST[$item])) {
            // return that data
            return $_POST[$item];
        // else if get data
        } else if (isset($_GET[$item])) {
            // return the get data
            return $_GET[$item];
        }
        // but return something anyways so no error would come up
        return '';
    }

}
?>
