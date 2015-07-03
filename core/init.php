<?php
// start the session
session_start();
// here is where you define everything about the database
$GLOBALS['config'] = array('mysql' => array('host' => 'localhost', 'username' => 'root', 'password' => 'ichigo', 'db' => 'groupproject'), 'remember' => array('cookie_name' => 'hash', 'cookie_expiry' => 30), 'session' => array('session_name' => 'user','session_date' => 'date', 'token_name' => 'token'));
// outoloader loads these classes by only requiring it once
spl_autoload_register(function($class) {
	// when say User = new User is passed then this will load the class
	require_once 'classes/' . $class . '.php';

});
// require the sanitize function which helps security cant use in the auto load since it is not a class
require_once 'functions/sanitize.php';

// check if cookie exists, check if user is logged in or not
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	// hash check  and get cookie
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance() -> get('users_session', array('hash', '=', $hash));

	// if the hash exists in the DB then login the user
	if ($hashCheck -> count()) {
		// logs the user in by the user first ID (so same as the original login process just that if your hash matches the one in the DB it logs you in)
		$user = new User($hashCheck->first()->user_id);
		$user-> login();
	}
}
?>