<?php
include_once "../views/topfive_doc.php";

$product = array("name" => "Test Shopping Cart", "id" => "1", "quantity" => "6", "subtotal" => "1.00", "description" => "Water fountain test top five", "price" => "7.00", "filename_img" => "../../Images/waterfountain.jpg");

$data = array(
    'page' => 'topfive', 'genericErr' => '', 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    ), 'products' => array($product, $product)
);

$view = new TopFiveDoc($data);
$view->show();
