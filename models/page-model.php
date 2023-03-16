<?php

require_once("MenuItem.php");
require_once "session_manager.php";

class PageModel
{
    public $page;
    protected $isPost = false;
    public $menu;
    // public $errors = array();
    protected $sessionManager;

    public function __construct($page)
    {
        //$this->page = $page;
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

    function getPostVar($key)
    {
        return $this->getArrayVar($_POST, $key);
    }

    function getUrlVar($key)
    {
        return $this->getArrayVar($_GET, $key);
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function createMenuArr()
    {
        $this->menu['home'] = new MenuItem('home', 'Home');
        $this->menu['about'] = new MenuItem('about', 'About');
    }

    public function isLoggedIn()
    {
    }
}
