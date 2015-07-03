<?php

require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()) {

    die("0");
}


if(!$_POST['page']) die("0");

$page = (int)$_POST['page'];
// So I changed the page_ to test lets see if it works Cool so it is right here that You have to name it correctly as in prefix and number has to be the same
if(file_exists('pages/test'.$page.'.html'))
echo file_get_contents('pages/test'.$page.'.html');

else echo 'Problem Loading the Page Content';

?>
