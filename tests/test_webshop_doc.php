<?php
include_once "../views/webshop_doc.php";

$product = array("name" => "Test Webshop", "id" => "1", "quantity" => "6", "subtotal" => "1.00", "description" => "Scratching post test webshop", "price" => "1000.00", "filename_img" => "../../Images/scratchingpost.jpg");

$data = array(
    'page' => 'webshop', 'genericErr' => '', 'menu' => array(
        'home' => 'Home', 'about' => 'About'
    ), 'products' => array($product, $product)
);

$view = new WebshopDoc($data);
$view->show();
