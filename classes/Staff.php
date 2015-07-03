<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// user class to literaly manipulate the user any way
class Staff {
    // database, data, session name, is logged in and cookie
    private $_db;

    private $database;
    private $conn;  // Adding the connection, more on this later.
    // get user data, current data if users data was defined
    public function __construct() {
        // connect to databse
        $this -> _db = DB::getInstance();

        $this ->conn = $this ->_db ->conn();
        // Get the session name from the Config file


    }


    // creates a user
    public function create($fields = array()) {
        // insert the new user into the database
        if (!$this -> _db -> insert('staff', $fields)) {
            // if staetment does not work out than we throw a exception
            throw new Exception('There was a problem creating an account.');
        }
    }


    public function Database($set_database)
    {
        $this->database=$set_database;
        // Adding the connection to the function allows you to have multiple
        // different connections at the same time.  Without it, it would use
        // the most recent connection.
        mysql_select_db($this->database, $this->conn) or die("cannot select Dataabase");
    }

    public function Fetch($set_table_name){

        $query=mysql_query("SELECT * FROM ".$set_table_name);
        $result = array();
        while ($record = mysql_fetch_array($query)) {
            $result[] = $record;
        }
        return $result;
    }

    public function FetchImage($set_table_name,$id){

        $query=mysql_query("SELECT * FROM $set_table_name WHERE id=$id");
        $result = array();
        while ($record = mysql_fetch_array($query)) {
            $result[] = $record;
        }
        return $result;
    }

}