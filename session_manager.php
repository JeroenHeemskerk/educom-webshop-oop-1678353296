<?php

class SessionManager
{

    public function logUserIn($name, $id, $isadmin)
    {
        $_SESSION['username'] = $name;
        $_SESSION['userid'] = $id;
        $_SESSION['shoppingcart'] = array(); 
        $_SESSION['isadmin'] = $isadmin;      
    }

    public function getLoggedInUserId()
    {
        return $_SESSION['userid'];
    }

    public function getLoggedInUserName()
    {
        return $_SESSION['username'];
    }

    public function logUserOut()
    {
        session_unset();
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    public function getShoppingcart()
    {
        return $_SESSION['shoppingcart'];
    }

    public function updateShoppingCart($productId, $quantity)
    {
        $_SESSION['shoppingcart'][$productId] = $quantity;
    }

    public function removeFromShoppingcart($productId)
    {
        unset($_SESSION['shoppingcart'][$productId]);
    }

    public function emptyShoppingCart()
    {
        $_SESSION['shoppingcart'] = array();
    }
}
