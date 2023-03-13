<?php
include_once "../views/login_doc.php";

$data = array(
    "page" => "login", "userid" => "userid",
    "name" => "name", "email" => "",
    "password" => "", "emailErr" => "",
    "passwordErr" => "", "genericErr" => "", "valid" => false, 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    )
);

$view = new LoginDoc($data);
$view->show();
