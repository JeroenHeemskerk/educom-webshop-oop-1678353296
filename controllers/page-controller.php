<?php

class PageController
{
    private $model;

    public function __construct($pageModel)
    {
        $this->model = $pageModel;
    }

    public function handleRequest()
    {
        $this->getRequest();
        $this->processRequest();
        $this->showResponsePage();
    }

    // =================================================================
    // from client
    // =================================================================

    private function getRequest()
    {
        $this->model->getRequestedPage();
    }

    // =================================================================
    // business flow logic
    // =================================================================

    private function processRequest()
    {
        switch ($this->model->page) {
            case "home":
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->handleActions();
                break;
            case "about":
                break;
            case 'contact':
                require_once("models/user-model.php");
                require_once("cruds/user_crud.php");
                $userCrud = new UserCrud($this->model->crud);
                $this->model = new UserModel($this->model, $userCrud);
                $this->model->validateContact();
                if ($this->model->valid) {
                    $this->model->setPage('thanks');
                }
                break;
            case "login":
                require_once("models/user-model.php");
                require_once("cruds/shop_crud.php");
                $userCrud = new UserCrud($this->model->crud);
                $this->model = new UserModel($this->model, $userCrud);
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage("home");
                }
                break;
            case "logout":
                require_once("models/user-model.php");
                require_once("cruds/user_crud.php");
                $userCrud = new UserCrud($this->model->crud);
                $this->model = new UserModel($this->model, $userCrud);
                $this->model->doLogoutUser();
                $this->model->setPage("home");
                break;
            case 'changepassword':
                require_once("models/user-model.php");
                require_once("cruds/user_crud.php");
                $userCrud = new UserCrud($this->model->crud);
                $this->model = new UserModel($this->model, $userCrud);
                $this->model->validateChangePassword();
                if ($this->model->valid) {
                    $this->model->updatePassword($this->model->userId, $this->model->newPassword);
                    $this->model->setPage('home');
                }
                break;
            case 'register':
                require_once("models/user-model.php");
                require_once("cruds/user_crud.php");
                $userCrud = new UserCrud($this->model->crud);
                $this->model = new UserModel($this->model, $userCrud);
                $this->model->validateRegistration();
                if ($this->model->valid) {
                    $this->model->storeUser();
                    $this->model->setPage('login');
                }
                break;
            case 'webshop':
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->handleActions();
                $this->model->getWebshopProducts();
                break;
            case 'shoppingcart':
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->handleActions();
                if ($this->model->valid) {
                    $this->model->getWebshopProducts();
                    $this->model->setPage("webshop");
                } else {
                    $this->model->getShoppingcartProducts();
                }
                break;
            case 'productdetail':
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->handleActions();
                $id = $this->model->getUrlVar("id");
                $this->model->getProductDetails($id);
                break;
            case 'topfive':
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->getTopProducts();
                break;
            case 'addnewproduct':
                require_once("models/shop-model.php");
                require_once("cruds/shop_crud.php");
                $shopCrud = new ShopCrud($this->model->crud);
                $this->model = new ShopModel($this->model, $shopCrud);
                $this->model->validateProduct();
                if($this->model->valid) {
                    $this->model->storeNewProduct();
                }
                break;
        }
    }

    // =================================================================
    // to client: presentation layer
    // =================================================================

    private function showResponsePage()
    {
        $this->model->createMenuArr();
        $current_page = $this->model->page;
        if (@include_once("views/{$current_page}_doc.php")) { // @ - to suppress warnings             
            $class = "{$current_page}Doc";
            $view = new $class($this->model);
        } else {
            debugToConsole("unknown page: " . $current_page);
            require_once("views/home_doc.php");
            $view = new HomeDoc($this->model);
        }
        $view->show();
    }
}

// =================================================================
// Logging
// =================================================================

function debugToConsole($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}
