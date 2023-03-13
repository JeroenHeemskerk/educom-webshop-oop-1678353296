<?php
include_once "../views/changepassword_doc.php";

$data = array(
    "page" => "changepassword", "id" => "id", "password" => "",
    "newPassword" => "newPassword", "passwordErr" => "",
    "newPasswordErr" => "", "genericErr" => "", "valid" => false, 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    )
);

$view = new ChangePasswordDoc($data);
$view->show();
