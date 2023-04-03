<?php

include_once "html_doc.php";


class BasicDoc extends HtmlDoc
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    private function title()
    {
        echo "<title>";
        $this->showHead();
        echo "</title>";
    }

    protected function showHead()
    {
        echo $this->model->page;
    }

    private function cssLinks()
    {
        echo '<link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/x-icon" href="css/favicon.ico">';
    }

    // Override 
    function showHeadContent()
    {
        $this->title();
        $this->cssLinks();
    }

    // Override
    function showBodyStart()
    {
        echo '<body>' . PHP_EOL;
        echo '<div id="page-container">
        <div id="content-wrap">' . PHP_EOL;
    }

    function showHeader($page)
    {
        switch ($page) {
            case 'home':
            case 'about':
            case 'contact':
            case 'thanks':
            case 'register':
            case 'login':
            case 'changepassword':
            case 'webshop':
            case 'productdetail':
            case 'shoppingcart':
            case 'topfive':
            case 'addnewproduct':
                echo '<header>
        <h1>' . strtoupper($page) . '</h1>
      </header>';
                break;
            default:
                echo '<h1>Page not found</h1>';
                break;
        }
    }

    function showMenu()

    {
        echo '<ul class="menu"><nav>';
        foreach ($this->model->menu as $MenuItem) {
            echo $MenuItem->showMenuItem();
        }
        echo '</nav></ul>';
    }

    function showMenuItem($link, $label)
    {
        echo '
        <a href="index.php?page=' . $link . '">
        <li>' . $label .  '</li>
        </a>';
    }

    protected function showContent()
    {
        echo '<p>Content</p>';
    }

    protected function showGenericErr()
    {
        echo '<p class="error">' . $this->model->genericErr . '</p>';
    }

    protected function showGenericSuccess()
    {
        echo '<p>' . $this->model->genericSuccess . '</p>';
    }


    function showFooter()
    {
        echo '
        </div>
        <footer>
        <p>&copy; <script>
        document.write(new Date().getFullYear())
        </script> Lydia van Gammeren All Rights Reserved</p>
        </footer>';
    }



    //Override
    protected function showBodyContent()
    {
        $this->showHeader($this->model->page);
        $this->showMenu();
        $this->showContent();
        $this->showGenericErr();
        $this->showGenericSuccess();
        $this->showFooter();
    }

    //Override
    protected function showBodyEnd()
    {
        echo '</div>' . PHP_EOL;
        echo '    </body>' . PHP_EOL;
    }
}
