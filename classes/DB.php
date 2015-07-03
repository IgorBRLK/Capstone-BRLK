<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// the best class ever
// pdo stands for php data objects allows you to define what kind database you want to use

class DB {
    // sigleton pattern we don't have to connect to database again and again
    // private property and storing the instanciated database(object)
    private static $_instance = null;
    // private properties for this class
    // underscore means that it is private
    private $_pdo, $_query, $_error = false, $_results, $_count = 0;

    // contructor for the class runs when class is instanciated (notice that it is private so it will not be called by the person doing this DB = new DB)
    private function __construct() {
        // here we try to connect to the database, with a try/catch block if it fails it goes to the error message
        try {
            //PDO simply have host, database name, username, password (note mysql: is the type of database)
            $this -> _pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));

        } catch (PDOException $e) {
            die($e -> getMessage());
        }
    }

    public function conn(){
        return mysql_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'));
    }

    // check to see if the database connection was instanciated (if we dont we instanciate and if we do we return the instance)
    public static function getInstance() {
        // if it is not set create a new instance so we can use the object (so if instance is set that this if statement wont run and we are just returned with the current instance)
        if (!isset(self::$_instance)) {
            // new DB can be called here since it is inside the class
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    // two params in query the sql statement and the params
    public function query($sql, $params = array()) {
        // error back to false after a query is run so we know that the error is not for a different query
        $this -> _error = false;
        // assignment to variable and checking the statement(if pdo oject has gone to plan)
        if ($this -> _query = $this -> _pdo -> prepare($sql)) {
            // check if the paramiters exist
            $x = 1;
            if (count($params)) {
                // loop thourgh each thing defined in the param
                foreach ($params as $param) {
                    // bind the values (example SELECT username FROM users WHERE username = "?", array('value') the question mark would be 1 in x) basically assigning value to first question mark
                    $this -> _query -> bindValue($x, $param);
                    $x++;
                }

            }

            // execute the query if executed than
            if ($this -> _query -> execute()) {
                // store the result set since it is stored in _query (columns in database as abjects)
                $this -> _results = $this -> _query -> fetchAll(PDO::FETCH_OBJ);
                // count the amount of results returned
                $this -> _count = $this -> _query -> rowCount();
            } else {
                // else there was an error
                $this -> _error = true;
            }
        }
        // returns the current object we are working with
        return $this;
    }

    // allows to perform a specific action (select, delete, define table and specific field in the table)
    private function action($action, $table, $where = array()) {

        // check if the where has 3 field because we need a FIELD OPERATOR VALUE
        if (count($where) === 3) {
            // the operators that we will allow (don't want random stuff or mistakes)
            $operators = array('=', '>', '<', '>=', '<=');

            // three variables extracted from the "where array"
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            // check if the operators defined are in the array (what we are saying is "is the operator provided in the query in the list of operators we defined")
            if (in_array($operator, $operators)) {
                // YAY operator is one that we defined so now we build the query (the $action $table etc is what is passed into this function)
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                // this is our query string (? is the value which will be binded later on)
                // he a little tricky the sql string will be run and the value from $value = $where[2] will be binded to finish off the sql statement
                // this if statemnt "if not this query than error"
                if (!$this -> query($sql, array($value)) -> error()) {
                    // returnt the current oject we are in
                    return $this;
                    // HI
                }
            }
        }
        return false;
    }

    // get data (from a table and where)
    public function get($table, $where) {
        // the $this is the gotton from the $this that has the HI next to it
        // here we call the action which is set to Select everything from the table and where specified when method was called
        return $this -> action('SELECT *', $table, $where);
    }


    // delete data (from a table and where)
    public function delete($table, $where) {
        // here we call the action which deletes from the table and where we specified when calling the method
        return $this -> action('DELETE', $table, $where);
    }

    // inserts data into the database (given the table and fields)
    public function insert($table, $fields = array()) {
        // if we have data in your fields
        if (count($fields)) {
            // keys of the array
            $keys = array_keys($fields);
            // variable keep track of the question marks
            $values = '';
            //counter
            $x = 1;

            // list of values looping through the fields
            foreach ($fields as $field) {
                // adding a ? to the values - if we had '?, ' it would be ?,?,?, the comma at the end is no go
                $values .= '?';
                // are we at the end of the defined fields
                if ($x < count($fields)) {
                    // if not the end put a comma between the first value and the next
                    $values .= ', ';
                }
                $x++;

            }
            // warning confusing formating (Basicaly what this outputs to is "INSERT INTO table('?','?','?')"
            $sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES({$values})";

            // this is where the question marks are bound to the values
            if (!$this -> query($sql, $fields) -> error()) {
                return true;
            }
        }

        return false;
    }

    // update tables (where table, id, and fields)
    public function update($table, $id, $fields) {
        if (count($fields)) {
            // set a empty string
            $set = '';
            // x incremented for each field
            $x = 1;

            // for each loop to loop through the params we want to update
            foreach ($fields as $name => $value) {
                // just as for the insert we put the values equeal to question marks(by the way this is to prevent sql injection)
                $set .= "{$name} = ?";
                // go through all the fields that we want to update and continue until it runs out, also put a comma between each param
                if ($x < count($fields)) {
                    // set comma between each value so thet it looks something like this (UPDATE users SET password=?,name=?,Where id = 3)
                    $set .= ', ';
                }
                $x++;
            }

            // update a certain table we set a certain value at an ID that we want (this can be set to what every you want such as name or username just change the value before {$id})
            $sql = "UPDATE {$table} SET {$set} WHERE ID = {$id}";

            //perform the query by binding the qeustion marks with data
            if (!$this -> query($sql, $fields) -> error()) {
                return true;
            }
        }
        return false;

    }

    // returns the fetch all results
    public function results() {
        // returns the results of _results = $this -> _query -> fetchAll(PDO::FETCH_OBJ);
        return $this -> _results;
    }

    // returns the first result out of the result list
    public function first() {
        return $this -> results()[0];
    }

    // debuging tools below

    // public function that returns the error (by default it is false)
    public function error() {
        // something like this "if (query->error()){means error in query}else{means no error in query}"
        return $this -> _error;
    }

    // similar to error but will return true if there was something return from the query
    public function count() {
        // something like this "if (!query->count()){means nothing was returned}else{something was returned}"
        return $this -> _count;
    }

}
?>