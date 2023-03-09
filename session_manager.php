<?php

function logUserIn($data)
{
    $_SESSION['username'] = $data['name'];
    $_SESSION['userid'] = $data['userid'];
    $_SESSION['shoppingcart'] = array();
}

function getLoggedInUserId()
{
    return $_SESSION['userid'];
}

function getLoggedInUserName()
{
    return $_SESSION['username'];
}

function logUserOut()
{
    session_unset();
}

function isUserLoggedIn()
{
    return isset($_SESSION['username']);
}

function getShoppingcart()
{
    return $_SESSION['shoppingcart'];
}

function updateShoppingCart($productId, $quantity)
{
    $_SESSION['shoppingcart'][$productId] = $quantity;
}

function removeFromShoppingcart($productId)
{
    unset($_SESSION['shoppingcart'][$productId]);
}

function emptyShoppingCart()
{
    $_SESSION['shoppingcart'] = array();
}
