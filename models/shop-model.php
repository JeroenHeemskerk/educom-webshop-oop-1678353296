<?php

require_once "db_repository.php";


class ShopModel extends PageModel
{
    public $products = '';
    public $genericErr = NULL;
    public $data = '';
    public $product = array();
    public $action = '';
    public $productId = '';
    public $quantity = '';
    public $userId = 0;
    public $shoppingcartproducts = array();
    public $total = 0;
    public $shoppingcart = '';
    public $shoppingcartproduct = '';
    public $subtotal = '';
    public $canOrder = FALSE;
    public $cart = array();
    //public $detail_id = '';

    public function __construct($pageModel)
    {
        PARENT::__construct($pageModel);

        //$this->detail_id = $this->getUrlVar("id");
    }

    public function createMenuArr()
    {
        $this->canOrder = $this->sessionManager->isUserLoggedIn();
        $this->cart = $this->sessionManager->getShoppingcart();
        parent::createMenuArr();
    }

    function getWebshopProducts()
    {
        $this->products = array();
        $this->genericErr = NULL;
        try {
            $this->products = getAllProducts();
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show products at this moment.";
            debug_to_console("GetAllProducts failed  " . $e->getMessage());
        }
        return array("products" => $this->products, "genericErr" => $this->genericErr);
    }

    function getShoppingcartProducts()
    {
        try {
            $shoppingcart = $this->sessionManager->getShoppingcart();
            $this->products = getAllProducts();

            foreach ($shoppingcart as $productId => $quantity) {
                $product = $this->getArrayVar($this->products, $productId, NULL);

                $subtotal = number_format((float)($quantity * (float) $product['price']));
                $shoppingcartproduct = array(
                    'productId' => $productId, 'quantity' => $quantity, 'subtotal' => $subtotal,
                    'price' => $product['price'], 'name' => $product['name'], 'filename_img' => $product['filename_img']
                );
                $this->shoppingcartproducts[$productId] = $shoppingcartproduct;
                $this->total += $subtotal;
            }
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show products at this moment.";
            debug_to_console("GetShoppingcartProducts failed  " . $e->getMessage());
        }
    }

    function storeOrder()
    {
        saveOrder($this->userId, $this->shoppingcartproducts);
    }

    function handleActions()
    {

        $action = $this->getPostVar("action");
        switch ($action) {
            case 'updateShoppingCart':
                $this->productId = $this->getPostVar("id");
                $this->quantity = $this->getPostVar("quantity");
                $this->sessionManager->updateShoppingCart($this->productId, $this->quantity);
                break;
            case 'removeFromShoppingcart':
                $this->productId  = $this->getPostVar("id");
                $this->sessionManager->removeFromShoppingcart($this->productId);
                break;
            case 'order':
                $this->userId = $this->sessionManager->getLoggedInUserId();
                $this->getShoppingcartProducts();
                $this->storeOrder();
                $this->sessionManager->emptyShoppingCart();
                break;
        }
    }

    function getProductDetails($productId)
    {
        try {
            $this->product = findProductById($productId);
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show details at this moment.";
            debug_to_console("findProductById failed  " . $e->getMessage());
        }
        return array("product" => $this->product, "genericErr" => $this->genericErr);
    }
}
