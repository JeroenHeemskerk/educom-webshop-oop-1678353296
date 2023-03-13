<?php
include_once "../views/addnewproduct_doc.php";

$data = array(
    "page" => "addnewproduct", "name" => "name",
    "description" => "description",
    "price" => "price",
    "filename_img" => "filename_img",
    "nameErr" => "",
    "descriptionErr" => "", "priceErr" => "",
    "fileNameErr" => "", "genericErr" => "", "valid" => false,
    'menu' => array(
        'home' => 'Home', 'about' => 'About'
    )
);
$view = new AddNewProductDoc($data);
$view->show();
