<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'core/init.php';

$upload = new Upload();

$upload -> upload();
$upload -> getGroup();
$upload -> insertUsers();
$upload -> removeFile();

