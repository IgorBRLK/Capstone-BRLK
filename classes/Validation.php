<?php
// set up the validation to get the value being the name of the field
// very usefull class to check for all types of validation rules and kindly output the errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Validation {
    // has it passed or failed and a instance of the database
    private $_passed = false, $_errors = array(), $_db = null;

    // construct sets the instance of the database
    public function __construct() {
        $this -> _db = DB::getInstance();
    }

    // Data we want to check
    public function check($source, $items = array()) {
        // list through the rules we defined check with stuff we provided and if wrong give kind error
        // items in the array that we want to validate and their rules
        foreach ($items as $item => $rules) {
            // also loop through the set of rules 
            // these two loops list out all the rules
            foreach ($rules as $rule => $rule_value) {

                // value of what the user inputs trim it so no white spaces
                $value = trim($source[$item]);
                // sanatize the item
                $item = escape($item);
                // check if it exists in the first place so if rule required and is empty then we have a problem
                if ($rule === 'required' && empty($value)) {

                    if($item === 'password_current'){
                        $item = 'current password';
                    }

                    if($item ==='password_new'){
                        $item = 'new password';
                    }

                    // here we add the error to the error array (stating that if field is required)
                    $this -> addError("{$item} is required");

                    // check if the value is empty if it is not empty than go through all the rules that apply
                } else if (!empty($value)) {
                    // switch between the rules and set the case to all the rules that we want to imliment this can be almost anything
                    switch($rule) {
                        case 'min' :
                            // if string length of the value is less than rule value
                            if (strlen($value) < $rule_value) {
                                if($item === 'password_current'){
                                    $item = 'current password';
                                }
                                $this -> addError("{$item} must be a minimum of {$rule_value} characters.");
                            }

                            break;

                        case 'max' :
                            // if string length of the value is more than the rule value
                            if (strlen($value) > $rule_value) {
                                $this -> addError("{$item} must be a maximum of {$rule_value} characters.");
                            }

                            break;

                        case 'matches' :
                            // password match (if value is not equal to source)
                            if ($value != $source[$rule_value]) {
                                $this -> addError("{$rule_value} must match {$item}");
                            }

                            break;

                        case 'unique' : // this unique can be applied to not only username but email adress also so that we don't have the user in there twice 
                            // database wrapper to get data (unique to a particular table such as users)
                            $check = $this -> _db -> get($rule_value, array($item, '=', $value));
                            // if there is a possitive count in the database than that means that value does exist in the database
                            if ($check -> count()) {
                                $this -> addError("{$item} already exists.");
                            }

                            break;
                    }
                }
            }
        }
        // check if the error list is empty if it is then passed is set to true
        if (empty($this -> _errors)) {
            $this -> _passed = true;
        }
        return $this;
    }

    // add a error to the error array
    private function addError($error) {
        $this -> _errors[] = $error;
    }
    
    // returns all the errors
    public function errors() {
        return $this -> _errors;
    }

    // check if fields passed
    public function passed() {
        return $this -> _passed;
    }

}
