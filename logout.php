<?php
// could check if the user is logged in
require_once 'core/init.php';
// this would be the current user just as discussed earlier
$user = new User();
// and we call the user logout method
$user -> logout();
// redirect to indext.php
Redirect::to('index.php');
?>