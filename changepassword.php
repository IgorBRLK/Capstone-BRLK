<?php
require_once 'core/init.php';
// new user
$user = new User();
// if user is not logged in redirect to index.php
if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}
// if input exists again this is the submit button
if(Input::exists()){
	// check the token
	if (Token::check(Input::get('token'))) {
		// creat a new validation
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
			'required'=> true,
			'min'=> 6),
			'password_new' => array(
			'required' => true,
			'min' => 6,
			),
			'password_new_again' => array(
			'required'=> true,
			'min' => 6,
			'matches' => 'password_new'
			)
			
		));
		// if validation passed we make a hash with the current password check it to the one in the DB if not match then wrong
		if($validation->passed()){
			$password = Input::get('password_current');
            $checkpassword = Input::get('password_new');
            if (preg_match('/_/', $checkpassword))
            {
                Session::flash('special',"Please no underscores in new password");
                Redirect::to('changepassword.php');

            }
			if(Hash::make(Input::get('password_current'), $user->data()->salt) == $user->data()->password || $password == $user -> data() -> password){
				// else create new salt and update the current users password with the new one
				$salt = Hash::salt(32);
				$user->update(array(
				'password' => Hash::make(Input::get('password_new'), $salt),
				'salt' => $salt
				));
				// output that the password has been changed and redirect to index
				Session::flash('updated', 'Your password has been changed! Please use new password on next login');
				Redirect::to('loginPages.php');
				
			}else{
				Session::flash('special', 'Incorrect Current Password');
                Redirect::to('changepassword.php');
			}
			
			
		} else {
			// errors with the validation
			foreach ($validation-> errors() as $error) {
                Session::flash('special', $error.'<br>');
                Redirect::to('changepassword.php');
			}
		}
		
	}
}

?>

<?php
include 'includes/html/header.html';
if(Session::exists('updatePass')){
    echo '<h3>' . Session::flash('updatePass') . '</h3>' ; } ?>

<p>Please Enter the password emailed in the current password</p>
<form action="" method="post">
	<div class="field">
		<label for="password_current">Current password</label>
		<input type="password" name="password_current" id="password_current">
	</div>
	
	<form action="" method="post">
	<div class="field">
		<label for="password_new">New password</label>
		<input type="password" name="password_new" id="password_new">
	</div>
	
	<form action="" method="post">
	<div class="field">
		<label for="password_new_again">New password again</label>
		<input type="password" name="password_new_again" id="password_new_again">
	</div>
	<input type="submit" value="Change">
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	
</form>
<?php
if(Session::exists('special')){
    echo '<h3>' . Session::flash('special') . '</h3>' ; } ?>
     <?php include 'includes/html/footer.html'; ?>