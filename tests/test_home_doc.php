<?PHP

include_once "../views/home_doc.php";

$data = array('page' => 'home', 'menu' => array(
    'home' => 'Home', 'about' => 'About'
));

$view = new HomeDoc($data);

$view->show();