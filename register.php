<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'core/init.php';
// if input exists
// We can set this up at admin for individual login if batch creation is not necessary.
if (Input::exists()) {
    // check if token is there (this stuff is confusing)
    if(Token::check(Input::get('token'))) {
        // new validation instantiation
        $validate = new Validation();
        // check the Post data of the fields defined (the rules are defined in the array)
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));
        // if validation passed then register user
        if ($validation->passed()) {
            // isnstanciate a new user and gives access to DB
            $user = new User();
            // salt created here which is random 
            $salt =Hash::salt(32);
            // try method since we have a throw exception in the class
            try{
                // the create method where we fill in all the information for the user(This is where the user is inserted into the DB) see the group this could be inputed by admin
                $user->create(array(
                    'username' => Input::get('username'),
                    // the hash is made with the make method with the users password with the salt made before added to it
                    'password' => Hash::make(Input::get('password'),$salt),
                    // store the salt really important otherwise we would not be able to compare the hashes
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));


            // catch the problem if there is one (this is not the best way of doing it we should redirect to a pretty page saying there was a problem)
            }catch (Exception $e){
                // show the error message
                die ($e->getMessage());
            }
        } else {
            // here is where we output all the errors (here is where you make the markup much much nicer OK) -------------------------------------------------------------------
            foreach($validation->errors() as $error){
                echo $error,'<br>';
            }
        }
    }
    /// here is where we see the flash method used. (this is when the user is registered succesfully)
    Session::flash('home','you have been registered and can now log in!');
    // redirected to the index or where ever in your case since the admin is inputing the users than it would just be
    Redirect::to('index.php');
}

?>


<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>"
               autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Enter your password again</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">

</form>