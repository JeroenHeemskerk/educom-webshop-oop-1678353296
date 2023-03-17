<?php

//require_once("user_service.php");

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
                // require_once("models/page-model.php");
                // $this->model = new PageModel($this->model);
                //$this->model->handleActions();
                break;
            case 'contact':
                require_once("models/user-model.php");
                $this->model = new UserModel($this->model);
                $this->model->validateContact();
                if ($this->model->valid) {
                    $this->model->setPage('thanks');
                }
                break;
            case "login":
                require_once("models/user-model.php");
                $this->model = new UserModel($this->model);
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage("home");
                }
                break;
            case "logout":
                require_once("models/user-model.php");
                $this->model = new UserModel($this->model);
                $this->model->doLogoutUser();
                $this->model->setPage("home");
                break;
            case 'changepassword':
                require_once("models/user-model.php");
                $this->model = new UserModel($this->model);
                $this->model->validateChangePassword();
                if ($this->model->valid) {
                    try {
                        $this->model->updatePassword($this->model->userId, $this->model->newPassword);
                        $this->model->setPage('home');
                    } catch (Exception $e) {
                        echo "Password could not be changed due to a technical error";
                        debug_to_console("Change user password failed" . $e->getMessage());
                    }
                }
                break;
            case 'register':
                require_once("models/user-model.php");
                $this->model = new UserModel($this->model);
                $this->model->validateRegistration();
                if ($this->model->valid) {                    
                    try {
                        $this->model->storeUser($this->model->email, $this->model->name, $this->model->password);
                        //$this->model = new UserModel($this->model);
                        $this->model->setPage('login');
                    } catch (Exception $e) {
                        echo "Name could not be stored due to a technical error";
                        debug_to_console("Store user failed" . $e->getMessage());
                    }
                }
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
