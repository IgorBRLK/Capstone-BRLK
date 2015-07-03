<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'core/init.php';


            $user = new User();

            $remember = false;

            $userName = $_GET['name'];
            $password = $_GET['password'];
            $login = $user -> login($userName, $password, $remember);

            if ($login) {
                // get the time of when user logged in.
                $_SESSION[Config::get('session/session_date')] = time();
                // if login was successful than redirect
                Redirect::to('loginPages.php');

            } else {
                // else login failed
                echo 'sorry failed';
            }




