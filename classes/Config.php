<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// example echo Config::get('mysql/host');
// check if things actually exist when calling them
class Config {
    public static function get($path = null) {
        // check if path is passed
        if ($path) {
            // config from the globals
            $config = $GLOBALS['config'];
            // break up the pieces
            $path = explode('/', $path);

            // each part of exploded path is a bit
            foreach ($path as $bit) {
                // the name is in the config then set it
                if (isset($config[$bit])) {
                    // example does mysql exist in config if it does then mysql is config and host is displayed
                    $config = $config[$bit];
                }

            }
            return $config;
        }
        return false;
    }

}

?>
