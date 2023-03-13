<?PHP

// =================================================================
// Main App
// =================================================================

include_once 'validations.php';
include_once 'session_manager.php';
include_once 'products_service.php';

session_start();

$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

// =================================================================
// Functions
// =================================================================

function getRequestedPage()
{
    $request_type = $_SERVER['REQUEST_METHOD'];

    if ($request_type == 'POST') {
        $requested_page = getPostVar('page', 'home');
    } else if ($request_type == 'GET') {
        $requested_page = getUrlVar('page', 'home');
    }
    return $requested_page;
}

function getArrayVar($array, $key, $default = '')
{
    return isset($array[$key]) ? $array[$key] : $default;
}

function getPostVar($key)
{
    return getArrayVar($_POST, $key);
}

function getUrlVar($key)
{
    return getArrayVar($_GET, $key);
}

function processRequest($page)
{

    switch ($page) {
        case 'home':
            $data = handleActions();
            break;
        case 'about':
            break;
        case 'addnewproduct':
            $data = validateAddProduct();
            if ($data['valid']) {
                try {
                    storeNewProduct(
                        $data['name'],
                        $data['description'],
                        $data['price'],
                        $data['filename_img']
                    );
                    $page = 'webshop';
                    $data = array_merge($data, getWebshopProducts());
                } catch (Exception $e) {
                    $data['genericErr'] = "Product could not be stored due to a technical error";
                    debug_to_console("Store product failed" . $e->getMessage());
                }
            }
            break;
        case 'shoppingcart':
            $data = handleActions();
            $data = array_merge($data, getShoppingCartProducts());
            break;
        case 'webshop':
            $data = handleActions();
            $data = array_merge($data, getWebshopProducts());
            break;
        case 'productdetail':
            $data = handleActions();
            $id = getUrlVar("id");
            $data = array_merge($data, getProductDetails($id));
            break;
        case 'topfive':
            $data = getTopProducts();
            break;
        case 'contact':
            $data = validateContact();
            if ($data['valid']) {
                $page = 'thanks';
            };
            break;
        case 'register':
            $data = validateRegistration();
            if ($data['valid']) {
                try {
                    storeUser($data['email'], $data['name'], $data['password']);
                    $page = 'login';
                } catch (Exception $e) {
                    $data['genericErr'] = "Name could not be stored due to a technical error";
                    debug_to_console("Store user failed" . $e->getMessage());
                }
            }
            break;
        case 'login':
            $data = validateLogin();
            if ($data['valid']) {
                logUserIn($data);
                $page = 'home';
            }
            break;
        case 'logout':
            logUserOut();
            $page = 'home';
            break;
        case 'changepassword':
            $data = validateChangePassword();
            if ($data['valid']) {
                try {
                    updatePassword($data['id'], $data['newPassword']);
                    $page = 'home';
                } catch (Exception $e) {
                    $data['confirmPasswordErr'] = "Password could not be changed due to a technical error";
                    debug_to_console("Change user password failed" . $e->getMessage());
                }
            }
            break;
        default:
            $page = 'unknown';
    }
    $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'webshop' => 'Webshop', 'topfive' => 'Top Five Products');

    if (isUserLoggedIn()) {
        $data['menu']['logout'] = "Logout " . getLoggedInUserName();
        $data['menu']['changepassword'] = "Change Password ";
        $data['menu']['shoppingcart'] = "Shopping Cart ";
    } else {
        $data['menu']['register'] = "Register";
        $data['menu']['login'] = "Login";
    }
    $data['page'] = $page;
    return $data;
}
function showResponsePage($data)
{
    $current_page = $data['page'];
    if ($current_page !== 'unknown') {
        include "$current_page.php";
    }

    beginDocument();
    showHeadSection($current_page);

    if ($current_page !== 'unknown') {
        showBody($current_page, $data);
    } else {
        echo 'No such page.';
    }

    endDocument();
}


function beginDocument()
{
    echo '<!doctype html> 
              <html>';
}

function showHeadSection($page)
{

    echo '<head>
    <title>' . strtoupper($page) . '</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" type="image/x-icon" href="CSS/favicon.ico">
  </head>';
}

// =================================================================
// Functions for Body
// =================================================================
function showBody($current_page, $data)
{
    showBodyStart();
    showHeader($current_page);
    showMenu($data);
    showContent($data);
    showFooter();
    showBodyEnd();
}


function showBodyStart()
{

    echo '    <body>' . PHP_EOL;
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

function showMenu($data)

{
    echo '<ul class="menu"><nav>';
    foreach ($data['menu'] as $link => $label) {
        showMenuItem($link, $label);
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

function showBodyEnd()
{
    echo '</div>' . PHP_EOL;
    echo '    </body>' . PHP_EOL;
}



// =================================================================

function endDocument()
{
    echo  '</html>';
}

// =================================================================
// Logging
// =================================================================

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}
