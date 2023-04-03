<?php

require_once("MenuItem.php");
require_once("session_manager.php");

class PageModel
{
    public $page;
    protected $isPost = false;
    public $menu;
    public $errors = array();
    public $genericErr = NULL;
    public $genericSuccess = NULL;
    public $crud;
    public $isAdminObject = NULL;   

    protected SessionManager $sessionManager;

    public function __construct($copy, $crud = NULL)
    {
        if (empty($copy) || $crud !== NULL) {
            // ==> First instance of PageModel
            $this->sessionManager = new SessionManager();
            $this->crud = $crud;
        } else {
            // ==> Called from the constructor of an extended class.... 
            $this->page = $copy->page;
            $this->isPost = $copy->isPost;
            $this->menu = $copy->menu;
            $this->sessionManager = $copy->sessionManager;
            $this->crud = $copy->crud;
            $this->genericErr = $copy->genericErr;
        }
    }

    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    public function getRequestedPage()
    {
        $this->isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');
        if ($this->isPost) {
            $this->setPage($this->getPostVar("page", "home"));
        } else {
            $this->setPage($this->getUrlVar("page", "home"));
        }
    }

    function getArrayVar($array, $key, $default = '')
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    function getObjectById($array, $id)
    {

        foreach ($array as $object) {
            if ($id == $object->id) {
                return $object;
            }
        }
    }

    function getPostVar($key)
    {
        return $this->getArrayVar($_POST, $key);
    }

    function getUrlVar($key, $default)
    {
        return $this->getArrayVar($_GET, $key, $default);
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function createMenuArr()
    {
        echo '<ul>';
        $this->menu['home'] = new MenuItem('home', 'Home');
        $this->menu['about'] = new MenuItem('about', 'About');
        $this->menu['contact'] = new MenuItem('contact', 'Contact');
        $this->menu['webshop'] = new MenuItem('webshop', 'Webshop');
        $this->menu['topfive'] = new MenuItem('topfive', 'Top Five');
        if ($this->sessionManager->isUserLoggedIn()) {
            $this->menu['shoppingcart'] = new MenuItem('shoppingcart', 'Shopping Cart');
            $this->menu['logout'] = new MenuItem('logout', 'Logout ' .
                $this->sessionManager->getLoggedInUsername());
            $this->menu['changepassword'] = new MenuItem('changepassword', 'Change Password');
        } else {
            $this->menu['login'] = new MenuItem('login', 'Login');
            $this->menu['register'] = new MenuItem('register', 'Register');
        }
        echo '<ul>';
    }

    public function isAdmin()
    {
        if ($this->sessionManager->isUserLoggedIn()) {
            if ($_SESSION['isadmin'] === 'yes') {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}
