<?php

include_once "html_doc.php";


class BasicDoc extends HtmlDoc
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }



    // Override 
    function showHeadContent()
    {
        echo ' 
        <title>BasicDoc Title</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../css/favicon.ico">';
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
        foreach ($this->data['menu'] as $link => $label) {
            $this->showMenuItem($link, $label);
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

    function showContent()
    {
        echo '<p>Content</p>';
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
        $this->showHeader($this->data['page']);
        $this->showMenu();
        $this->showContent();
        $this->showFooter();
    }

    //Override
    protected function showBodyEnd()
    {
        echo '</div>' . PHP_EOL;
        echo '    </body>' . PHP_EOL;
    }
}
