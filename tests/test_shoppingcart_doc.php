<?php
include_once "../views/shoppingcart_doc.php";

$product = array("name" => "Test Shopping Cart", "productId" => "1", "quantity" => "1", "subtotal" => "1.00", "description" => "Mouse toy test shopping cart", "price" => "1.00", "filename_img" => "../../Images/mousetoy.jpg");
$data = array(
    "page" => "shoppingcart", "genericErr" => "", 'menu' => array(
        'home' => 'Home', 'about' => 'About',
    ), 'shoppingcartproducts' => array($product, $product), 'total' => '9999'
);

$view = new ShoppingCartDoc($data);
$view->show();
