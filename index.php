<?PHP

// =================================================================
// Main App
// =================================================================

include_once 'validations.php';
include_once 'session_manager.php';
include_once 'products_service.php';

require_once("controllers/page-controller.php");

session_start();

$controller = new PageController();
$controller->handleRequest();


// =================================================================
// Functions
// =================================================================


// function processRequest($page)
// {

//     switch ($page) {
//         case 'home':
//             $data = handleActions();
//             break;
//         case 'about':
//             break;
//         case 'addnewproduct':
//             $data = validateAddProduct();
//             if ($data['valid']) {
//                 try {
//                     storeNewProduct(
//                         $data['name'],
//                         $data['description'],
//                         $data['price'],
//                         $data['filename_img']
//                     );
//                     $page = 'webshop';
//                     $data = array_merge($data, getWebshopProducts());
//                 } catch (Exception $e) {
//                     $data['genericErr'] = "Product could not be stored due to a technical error";
//                     debug_to_console("Store product failed" . $e->getMessage());
//                 }
//             }
//             break;
//         case 'shoppingcart':
//             $data = handleActions();
//             $data = array_merge($data, getShoppingCartProducts());
//             break;
//         case 'webshop':
//             $data = handleActions();
//             $data = array_merge($data, getWebshopProducts());
//             break;
//         case 'productdetail':
//             $data = handleActions();
//             $id = getUrlVar("id");
//             $data = array_merge($data, getProductDetails($id));
//             break;
//         case 'topfive':
//             $data = getTopProducts();
//             break;
//         case 'contact':
//             $data = validateContact();
//             if ($data['valid']) {
//                 $page = 'thanks';
//             };
//             break;
//         case 'register':
//             $data = validateRegistration();
//             if ($data['valid']) {
//                 try {
//                     storeUser($data['email'], $data['name'], $data['password']);
//                     $page = 'login';
//                 } catch (Exception $e) {
//                     $data['genericErr'] = "Name could not be stored due to a technical error";
//                     debug_to_console("Store user failed" . $e->getMessage());
//                 }
//             }
//             break;
//         case 'login':
//             $data = validateLogin();
//             if ($data['valid']) {
//                 logUserIn($data);
//                 $page = 'home';
//             }
//             break;
//         case 'logout':
//             logUserOut();
//             $page = 'home';
//             break;
//         case 'changepassword':
//             $data = validateChangePassword();
//             if ($data['valid']) {
//                 try {
//                     updatePassword($data['id'], $data['newPassword']);
//                     $page = 'home';
//                 } catch (Exception $e) {
//                     $data['confirmPasswordErr'] = "Password could not be changed due to a technical error";
//                     debug_to_console("Change user password failed" . $e->getMessage());
//                 }
//             }
//             break;
//         default:
//             $page = 'unknown';
//     }
//     $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'webshop' => 'Webshop', 'topfive' => 'Top Five Products');

//     if (isUserLoggedIn()) {
//         $data['menu']['logout'] = "Logout " . getLoggedInUserName();
//         $data['menu']['changepassword'] = "Change Password ";
//         $data['menu']['shoppingcart'] = "Shopping Cart ";
//     } else {
//         $data['menu']['register'] = "Register";
//         $data['menu']['login'] = "Login";
//     }
//     $data['page'] = $page;
//     return $data;
// }

// =================================================================
// Logging
// =================================================================

// function debug_to_console($data)
// {
//     $output = $data;
//     if (is_array($output))
//         $output = implode(',', $output);
//     echo "<script>console.log('Debug Objects: " . $output . "');</script>";
// }
