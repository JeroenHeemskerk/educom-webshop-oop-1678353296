<?PHP

include_once "../views/about_doc.php";

$data = array('page' => 'about', 'menu' => array(
    'home' => 'Home', 'about' => 'About'
));

$view = new AboutDoc($data);

$view->show();
