<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'core/init.php';

// check if input exists if the submit button is hit
if($_POST['login']) {

    if (Input::exists()) {
        // check the token
        if (Token::check(Input::get('token'))) {
            // new validation instance



            $validate = new Validation();
            // Validate
            $validation = $validate->check($_POST, array('userId' => array('required' => true), 'password' => array('required' => true)));
            // if validation passed then do the following
            if ($validation->passed()) {
                // instanciate new user
                $user = new User();
                // check if the remember me button is checked or not by using turnary
                $remember = (Input::get('remember') === 'on') ? true : false;


                // process login using the user methods (notice we also pass in the remember me into the login method)
                $login = $user->login(Input::get('userId'), Input::get('password'), $remember);

                // check if it was successful
                if ($login) {
                    // get the time of when user logged in.


                    $_SESSION[Config::get('session/session_date')] = time();

                    if(strpos(Input::get('password'),'IT_') !== false){
                        Session::flash('updatePass','Looks, Like this is your fist time logging in please change your password to your liking.');
                        exit(Redirect::to('changepassword.php'));
                    }
                    // if login was successful than redirect
                    Redirect::to('loginPages.php');

                } else {
                    Session::flash('home', 'Username or Password is incorrect');
                    // redirect to index
                    Redirect::to('index.php');
                }
            } else {
                // else for each of the validation errors echo out the error
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                }
            }
        }
    }
}