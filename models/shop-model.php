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
    public $productIdErr;
    public $oldfilenameimg;
    // ----------------------------------------------------------------    
    public $action = '';
    public $productId = 0;
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
            $this->productId = $this->test_input($this->getPostVar('productId'));
            $this->oldfilenameimg = $this->test_input($this->getPostVar('oldfilenameimg'));
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
            $this->validateImage();



            if (empty($this->nameErr) && empty($this->descriptionErr) && empty($this->priceErr) && empty($this->filename_imgErr) && empty($this->genericErr)) {
                $this->valid = true;
                $this->genericSuccess = "Product was successfully added";
            }
        } else {
            $this->productId = $this->test_input($this->getUrlVar('id', 0));
            if ($this->productId != 0) {
                $product = $this->crud->readProductById($this->productId);
                $this->name = $product->name;
                $this->oldfilenameimg = $product->filename_img;
                $this->description = $product->description;
                $this->price = $product->price;
            }
        }
    }

    function uploadImageForProductWithID($id)
    {
        if (!empty($this->filename_img)) {
            $target_dir = "C:/xampp/htdocs/educom-webshop-oop/Images/";
            $target_file = $target_dir . $id . "_" . basename($_FILES["filename_img"]["name"]);

            $this->uploadImage($target_file);
        }
    }

    function validateImage()
    {

        $this->filename_img = $this->test_input(basename($_FILES["filename_img"]["name"]));
        if (empty($this->filename_img)) {
            if ($this->productId == 0) {
                $this->filename_imgErr = "Please provide an image";
            }
            return;
        }
        $target_dir = "C:/xampp/htdocs/educom-webshop-oop/Images/";
        $target_file = $target_dir . $this->productId . "_" . $this->filename_img;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //check extension
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $this->genericErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        // check file size
        if ($_FILES["filename_img"]["size"] > 500000) {
            $this->genericErr = "Sorry, your file is too large.";
        }

        if ((bool)getimagesize($_FILES["filename_img"]["tmp_name"]) == false) {
            $this->genericErr = "Not an image.";
        }
    }

    function uploadImage($target_file)
    {

        if (move_uploaded_file($_FILES["filename_img"]["tmp_name"], $target_file)) {
        } else {
            $this->genericErr = "There was an error uploading your file.";
        }
    }

    function deleteOldImage()
    {
        if (!empty($this->filename_img) && !empty($this->oldfilenameimg)) {
            $target_dir = "C:/xampp/htdocs/educom-webshop-oop/Images/";
            
            unlink($target_dir . $this->oldfilenameimg);
        }
    }

    function storeOrUpdateProduct()
    {
        if ($this->productId == 0) {
            $id = $this->crud->createProduct($this->name, $this->description, $this->price, $_FILES["filename_img"]["name"]);
        } else {
            $id = $this->productId;
            $this->crud->updateProduct($this->productId, $this->name, $this->description, $this->price, $_FILES["filename_img"]["name"], $this->oldfilenameimg);
        }
        return $id;
    }
}
