<?php

include_once("./cruds/shop_crud.php");

class ShopModel extends PageModel
{
    public $products = '';
    public $product = array();
    public $valid = false;
    // values for new product
    public $name;
    public $nameErr;
    public $description;
    public $descriptionErr;
    public $price;
    public $priceErr;
    public $filename_img;
    public $filename_imgErr;
    // ----------------------------------------------------------------    
    public $action = '';
    public $productId = '';
    public $quantity = '';
    public $userId = 0;
    public $shoppingcartproducts = array();
    public $topFiveProducts = array();
    public $total = 0;
    public $shoppingcart = '';
    public $shoppingcartproduct = '';
    public $subtotal = '';
    public $canOrder = FALSE;
    public $cart = array();

    public function __construct($pageModel, $shopCrud)
    {
        PARENT::__construct($pageModel);
        $this->crud = $shopCrud;
    }

    //Override
    public function createMenuArr()
    {
        $this->canOrder = $this->sessionManager->isUserLoggedIn();
        if ($this->canOrder) {
            $this->cart = $this->sessionManager->getShoppingcart();
        }

        parent::createMenuArr();
    }

    function getWebshopProducts()
    {
        $this->products = array();
        $this->genericErr = NULL;
        try {
            $this->products = $this->crud->readAllProducts();
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show products at this moment.";
            debugToConsole("GetAllProducts failed  " . $e->getMessage());
        }
        return array("products" => $this->products, "genericErr" => $this->genericErr);
    }

    function getShoppingcartProducts()
    {
        try {
            $shoppingcart = $this->sessionManager->getShoppingcart();
            $this->products = $this->crud->readAllProducts();

            foreach ($shoppingcart as $productId => $quantity) {
                $product = $this->getObjectById($this->products, $productId);

                $subtotal = number_format((float)($quantity * (float) $product->price));
                $shoppingcartproduct = array(
                    'productId' => $productId, 'quantity' => $quantity, 'subtotal' => $subtotal,
                    'price' => $product->price, 'name' => $product->name, 'filename_img' => $product->filename_img
                );
                $this->shoppingcartproducts[$productId] = $shoppingcartproduct;
                $this->total += $subtotal;
            }
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show products at this moment.";
            debugToConsole("GetShoppingcartProducts failed  " . $e->getMessage());
        }
    }

    function storeOrder()
    {
        try {
            $this->crud->createOrder($this->userId, $this->shoppingcartproducts);
            $this->sessionManager->emptyShoppingCart();
            $this->valid = true;
        } catch (PDOException $e) {
            $this->genericErr = "Sorry, cannot store your order at this time.";
            debugToConsole("Store order failed  " . $e->getMessage());
        }
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
                break;
        }
    }

    function getProductDetails($productId)
    {
        try {
            $this->product = $this->crud->readProductById($productId);
        } catch (Exception $e) {
            $this->genericErr = "Sorry, cannot show details at this moment.";
            debugToConsole("findProductById failed  " . $e->getMessage());
        }
    }

    function getTopProducts()
    {

        try {
            $this->topFiveProducts = $this->crud->readTopFive();
        } catch (PDOException $e) {
            $this->genericErr = "Sorry, cannot show top products at this moment.";
            debugToConsole("getTopProducts failed  " . $e->getMessage());
        }
    }

    function validateProduct()
    {
        if ($this->isPost) {
            $this->name = $this->test_input($this->getPostVar("name"));
            if (empty($this->name)) {
                $this->nameErr = "Name is required";
            }
            $this->description = $this->test_input($this->getPostVar("description"));
            if (empty($this->description)) {
                $this->descriptionErr = "Description is required";
            }
            $this->price = $this->test_input($this->getPostVar("price"));
            if (empty($this->price)) {
                $this->priceErr = "Price is required";
            }

            $this->filename_img = $this->test_input($this->getPostVar("filename_img"));
            if (empty($this->filename_img)) {
                $this->filename_imgErr = "Image is required";
            }
            if (empty($this->nameErr) && empty($this->descriptionErr) && empty($this->priceErr) && empty($this->filename_imgErr)) {
                $this->valid = true;
            }
        }
    }

    function storeNewProduct()
    {
        $this->crud->createProduct($this->name, $this->description, $this->price, $this->filename_img);
    }
}
