<?php
include_once "../views/contact_doc.php";
define("SALUTATIONS", array("mrs" => "Mrs.", "ms" => "Ms.", "mx" => "Mx.", "mr" => "Mr."));
define("COM_PREFS", array("phone" => "phone", "email" => "email"));

$data = array(
    'page' => 'contact', "salutation" => "salutation", "name" => "",
    "email" => "", "phone" => "phone",
    "contactOption" => "contactOption",
    "message" => "message",
    "nameErr" => "", "emailErr" => "", "phoneErr" => "",
    "contactOptionErr" => "", "messageErr" => "", "genericErr" => "",
    "valid" => false, 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    )
);

$view = new ContactDoc($data);
$view->show();
