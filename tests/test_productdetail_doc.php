<?php
include_once "../views/productdetail_doc.php";

$data = array(
    "page" => "productdetail", "genericErr" => "", 'menu' => array(
        'home' => 'Home', 'about' => 'About',
    ), 'product' => array(
        'id' => '5', 'name' => 'Product', 'filename_img' => 'Test.jpg',
        'description' => 'Dummy Description', 'price' => '$55',
    )
);

$view = new ProductDetailDoc($data);
$view->show();
