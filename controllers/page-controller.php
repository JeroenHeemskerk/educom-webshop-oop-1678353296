<?php

require_once "models/page-model.php";

class PageController
{
    private $model;

    public function __construct()
    {
        $this->model = new PageModel(NULL);
    }

    public function handleRequest()
    {
        $this->getRequest();
        //$this->processRequest();
        $this->showResponsePage();
    }

    // from client
    private function getRequest()
    {
        $this->model->getRequestedPage();
    }

    // business flow logic
    private function processRequest()
    {
        switch ($this->model->page) {
            case "home":
            case "about":
                require_once("models/page-model.php");
                $this->model = new PageModel($this->model);
                //$this->model->handleActions();
                break;
        }
    }

    // to client: presentation layer
    private function showResponsePage()
    {
        try {
            $this->model->createMenuArr();
            $current_page = $this->model->page;
            if (!@include_once("views/{$current_page}_doc.php")) // @ - to suppress warnings                
            {
                throw new Exception("views/{$current_page}_doc.php does not exist");
            }
            require_once("views/{$current_page}_doc.php");
            $class = "{$current_page}Doc";
            $view = new $class($this->model);
            $view->show($current_page);
        } catch (Exception $e) {
            echo '<a href="index.php?page=home">Go to homepage</a>';
            debug_to_console($e->getMessage());
            require_once("views/html_doc.php");
            $view = new HtmlDoc($this->model);
            $view->show();
        }
    }
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}
