<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// user class to literaly manipulate the user any way
class User {
	// database, data, session name, is logged in and cookie
	private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;

	// get user data, current data if users data was defined
	public function __construct($user = null) {
		// connect to databse
		$this -> _db = DB::getInstance();
		// Get the session name from the Config file
		$this -> _sessionName = Config::get('session/session_name');
		
		// get the cookie that is in the Config file
		$this -> _cookieName = Config::get('remember/cookie_name');

		// if not user
		if (!$user) {
			// if session exists
			if (Session::exists($this -> _sessionName)) {
				// user will the the current user logged in
				$user = Session::get($this -> _sessionName);
				// check if the user exists in the DB this also gives us all the user informaiton
				if ($this -> find($user)) {
					// flag to set the property of is logged in to true
					$this -> _isLoggedIn = true;

				} else {
					//process logout
				}
			}
		} else {
			// if the user has been defined we want to find he user in the DB (This allows us to get data from a user that is not logged in
			//(so if admin is logged in they can still get information from another user))
			//example $user = new User() is the current logged in user but $user2 = new User(5) is the user with the ID of five $user2->data()->username would be username of User id 5
			$this -> find($user);
		}

	}

	// update method for user update name profile
	public function update($fields = array(), $id = null) {
		// admin allows to update user profiles example $user-update(array('name' => Input::get('name'),4));
		if (!$id && $this -> isLoggedIn()) {
			$id = $this -> data() -> id;
		}

		//update the user
		if (!$this -> _db -> update('users', $id, $fields)) {
			throw new Exception('There was a problem updating');
		}
	}

	// creates a user
	public function create($fields = array()) {
		// insert the new user into the database
		if (!$this -> _db -> insert('users', $fields)) {
			// if staetment does not work out than we throw a exception
			throw new Exception('There was a problem creating an account.');
		}
	}

	// the find user method
	public function find($user = null) {

		if ($user) {
			// this leterally allows the user to login with the ID or username this is just an example maybe we can have the user login with the email if they choose to
			$field = (is_numeric($user)) ? 'id' : 'username';
			// this is where we actually get the username
			$data = $this -> _db -> get('users', array($field, '=', $user));

			// this returns true if a user was returned
			if ($data -> count()) {
				// store the first username data returned
				$this -> _data = $data -> first();
				return true;
			}
		}
		return false;
	}

	// the user login method what is used to check if the user exists in the DB (by asking for the usernam password and if remember me was selected)
	public function login($username = null, $password = null, $remember = false) {

		// if no username is defined and this user exists log user in
		if (!$username && !$password && $this -> exists()) {
			// log user in
			Session::put($this -> _sessionName, $this -> data() -> id);

		} else {
			// find the username (check if the username exists in the DB) by the way _data in the find method has all the informaiton about the user
			$user = $this -> find($username);

			// true or false
			if ($user) {
				// check the password (fun by getting the users current hash and then recreating it by making a hash using the users password and the salt provided in the DB)
				if ($this -> data() -> password == Hash::make($password, $this -> data() -> salt) || $this -> data() -> password == $password) {
					// Set the user session by using the userID
					Session::put($this -> _sessionName, $this -> data() -> id);

					// check if the remeber me check box was clicked (the way this works is that the cookie will be stored in the database and on the computer so when user visits site it checks it)
					if ($remember) {
						// generate a hash make sure it does not exist in the DB
						$hash = Hash::unique();
						// check if hash has been stored in the database to the user ID
						$hashCheck = $this -> _db -> get('users_session', array('user_id', "=", $this -> data() -> id));

						// if we do not have a hash in the database
						if (!$hashCheck -> count()) {
							// insert a record into the Database
							$this -> _db -> insert('users_session', array('user_id' => $this -> data() -> id, 'hash' => $hash));

						} else {
							// else set the hash that is in the DB already
							$hash = $hashCheck -> first() -> hash;
						}
						// store the cookie with the cookie name from the Config We also store the cookie for as long as we defined. (I put it to 12 hours)
						Cookie::put($this -> _cookieName, $hash, Config::get('remember/cookie_expiry'));

					}

					return true;
				}
			}
		}
		return false;

	}

	// checks if user exists with the data provided
	public function exists() {
		// check if the data exist
		return (!empty($this -> _data)) ? true : false;
	}

	// checks the currents users permissions
	public function hasPermission($key) {
		// get the current group that the user is in(the group permission is in JSON) explained {"admin":1, "student":1} what this means is that this user is both a admin and student the 1 means true
		$group = $this -> _db -> get('groups', array('id', '=', $this -> data() -> group));
		// if user is in a group
		if ($group -> count()) {
			// JSON decoding this puts the code obove into an array so here would be a admin of 1 and student of 1
			$permissions = json_decode($group -> first() -> permissions, true);

			// now that we have an array we can do thigs with it
			if (array_key_exists($key, $permissions)) {
				if ($permissions[$key] == true) {
					return true;
				}
			}

		}
		return false;
	}

	// here is the method used to logout the user (simple right all we are doing is deleting the session)
	public function logout() {
// delete the stored session hash in the database as well. So a new one is assigned to the user when they log in
		$this -> _db -> delete('users_session', array('user_id', '=', $this -> data() -> id));
		Session::delete($this -> _sessionName);
		// delete the cookie
		Cookie::delete($this -> _cookieName);
		
	}

	//function that returns all the data on the user (cool so now we can use this and call it to see what group the user is in)
	public function data() {
		return $this -> _data;
	}

	// getter for the is Logged in private property (if($user->isLoggedIn()) will tell you if the user has been logged in)
	public function isLoggedIn() {
		return $this -> _isLoggedIn;
	}

}
?>