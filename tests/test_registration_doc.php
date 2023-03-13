<?php
include_once "../views/registration_doc.php";

$data = array(
    "page" => "register", "name" => "", "email" => "", "password" => "",
    "confirmPassword" => "confirmPassword",
    "nameErr" => "", "emailErr" => "", "passwordErr" => "",
    "confirmPasswordErr" => "", "genericErr" => "", "valid" => false, 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    )
);

$view = new RegistrationDoc($data);
$view->show();
