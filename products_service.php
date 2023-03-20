<?php

include_once 'forms.php';
include_once 'db_repository.php';


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
