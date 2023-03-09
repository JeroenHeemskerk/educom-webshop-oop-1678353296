<?php

include_once 'forms.php';

function getWebshopProducts()
{
    $products = array();
    $genericErr = "";
    try {
        $products = getAllProducts();
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show products at this moment.";
        debug_to_console("GetAllProducts failed  " . $e->getMessage());
    }
    return array("products" => $products, "genericErr" => $genericErr);
}

function getProductDetails($productId)
{
    $product = array();
    $genericErr = "";
    try {
        $product = findProductById($productId);
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show details at this moment.";
        debug_to_console("findProductById failed  " . $e->getMessage());
    }
    return array("product" => $product, "genericErr" => $genericErr);
}

function addAction($nextpage, $button, $action, $productId = NULL, $name = NULL, $addquantity = 0)
{
    if (isUserLoggedIn()) {
        showFormStart();
        echo '<input type="hidden" name="action" value="' . $action . '">' . PHP_EOL;
        if ($productId) {
            echo '<input type="hidden" name="id" value="' . $productId . '">' . PHP_EOL;
        }
        if ($name) {
            echo '<input type="hidden" name="name" value="' . $name . '">' . PHP_EOL;
        }
        echo '<input type="hidden" name="page" value="' . $nextpage . '">' . PHP_EOL;
        if ($addquantity !== 0) {
            $cart = getShoppingcart();
            $quantity = ((float) $addquantity + getArrayVar($cart, $productId, 0));
            echo '<input type="hidden" name="quantity" value="' . $quantity . '">' . PHP_EOL;
            if ($quantity == 0) {
                echo '<input type="hidden" name="action" value="removeFromShoppingcart">' . PHP_EOL;
            }
        }

        showFormEnd($button, $nextpage);
    }
}

function handleActions()
{
    $data = array();
    $action = getPostVar("action");
    switch ($action) {
        case 'updateShoppingCart':
            $productId = getPostVar("id");
            $quantity = getPostVar("quantity");
            updateShoppingCart($productId, $quantity);
            break;
        case 'removeFromShoppingcart':
            $productId = getPostVar("id");
            removeFromShoppingcart($productId);
            break;
        case 'order':
            $user_id = getLoggedInUserId();
            $data = getShoppingcartProducts();
            $data = storeOrder($user_id, $data['shoppingcartproducts']);
            emptyShoppingCart();
            break;
    }
    return $data;
}

function getShoppingcartProducts()
{
    $shoppingcartproducts = array();
    $total = 0;
    $genericErr = "";
    try {
        $shoppingcart = getShoppingcart();
        $products = getAllProducts();

        foreach ($shoppingcart as $productId => $quantity) {
            $product = getArrayVar($products, $productId, NULL);

            $subtotal = number_format((float)($quantity * (float) $product['price']), 2);
            $shoppingcartproduct = array(
                'productId' => $productId, 'quantity' => $quantity, 'subtotal' => $subtotal,
                'price' => $product['price'], 'name' => $product['name'], 'filename_img' => $product['filename_img']
            );
            $shoppingcartproducts[] = $shoppingcartproduct;
            $total += $subtotal;
        }
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show products at this moment.";
        debug_to_console("GetShoppingcartProducts failed  " . $e->getMessage());
    }
    return array("shoppingcartproducts" => $shoppingcartproducts, "total" => number_format((float)($total), 2), "genericErr" => $genericErr);
}

function storeOrder($user_id, $shoppingcartproducts)
{
    saveOrder($user_id, $shoppingcartproducts);
}

function getTopProducts()
{
    $topFiveProducts = array();
    $genericErr = "";
    try {
        $topFiveProducts = getTopFive();
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show top products at this moment.";
        debug_to_console("getTopProducts failed  " . $e->getMessage());
    }
    return array("products" => $topFiveProducts, "genericErr" => $genericErr);
}

function storeNewProduct($name, $description, $price, $filename_img)
{
    saveProduct($name, $description, $price, $filename_img);
}
