<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'core/init.php';

$check = new Upload();
$check ->upload();
$check ->checkUsers();

