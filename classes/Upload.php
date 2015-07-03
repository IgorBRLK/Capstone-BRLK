<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'core/init.php';

class Upload
{
    // has it passed or failed and a instance of the database
    private $_file = null, $_pass = false, $_db = null, $_file_destination, $_group = 1;

    // construct sets the instance of the database
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function upload()
    {

        if (isset($_FILES['file'])) {

            $this->_file = $_FILES['file'];

            // File properties
            $file_name = $this->_file['name'];
            $file_tmp = $this->_file['tmp_name'];
            $file_size = $this->_file['size'];
            $file_error = $this->_file['error'];

            // file extension
            $file_ext = explode('.', $file_name);
            // end of array lower case
            $file_ext = strtolower(end($file_ext));

            //if allowed
            if ($file_ext === 'txt') {

                if ($file_error === 0) {

                    // Makes the directory if not existing
                    if ($file_size <= 1000) {
                        if (!file_exists('uploads/')) {
                            mkdir('uploads/', 0777, true);
                        }

                        $this->_file_destination = 'uploads/' . $file_name;

                        if (move_uploaded_file($file_tmp, $this->_file_destination)) {
                            $this->_pass = true;
                        }
                    } else {

                        Session::flash('adminTools', 'File size is to large');
                        // redirect to index
                        Redirect::to('loginPages.php');
                    }
                } else {
                    Session::flash('adminTools', 'Unknown problem with file');
                    // redirect to index
                    Redirect::to('loginPages.php');
                }
            } else {
                Session::flash('adminTools', 'Wrong file extension. txt is only excepted');
                // redirect to index
                Redirect::to('loginPages.php');
            }
            return $this->_pass;
        }
    }

    public function insertUsers()
    {

        $handle = fopen($this->_file_destination, "r");

        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {

                $user = new User();
                // password random with UC pre words salt created here which is random
                $password = "IT_ " . mt_rand();
                $salt = Hash::salt(32);

                // try method since we have a throw exception in the class
                try {
                    // the create method where we fill in all the information for the user(This is where the user is inserted into the DB) see the group this could be inputed by admin
                    $user->create(array(
                        'username' => trim($buffer),
                        // the hash is made with the make method with the users password with the salt made before added to it
                        'password' => $password,
                        // store the salt really important otherwise we would not be able to compare the hashes
                        'salt' => $salt,
                        'name' => $buffer,
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => $this->_group
                    ));

                    // catch the problem if there is one (this is not the best way of doing it we should redirect to a pretty page saying there was a problem)
                } catch (Exception $e) {
                    // show the error message
                    die ($e->getMessage());
                }

                /*$this -> _db -> insert('junk', array(
                            'names' => $buffer));*/

            }

        }
        Session::flash('adminTools', 'File was Uploaded/Users Created');
        // redirect to index
        Redirect::to('loginPages.php');
        fclose($handle);
    }

    public  function removeFile(){
        unlink($this->_file_destination);
    }

    public function getGroup()
    {
        if (isset($_POST['formGroup'])) {
            $this->_group = $_POST['formGroup'];
            echo $this->_group;

        } else {
            echo "Select a Group";
        }


    }

    public function checkUsers(){
        $foundUsers = array();
        $handle = fopen($this->_file_destination, "r");

        $pass = true;

        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {

                $user = new User();

                if($user ->find(trim($buffer))){
                    array_push($foundUsers, $buffer);
                    $pass = false;


                }

            }

        }
        $string = implode(" / ", $foundUsers);

        if($pass === false){
            Session::flash('adminTools','The Following User Names Exists: '. $string);
            Redirect::to('loginPages.php');
            $pass = true;
        }
        if($pass === true){
            Session::flash('adminTools', 'File is ready for upload, no duplicate users found.');
            // redirect to index
            Redirect::to('loginPages.php');
        }

        fclose($handle);

    }


}
	
	

