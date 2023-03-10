<?php
include_once "../views/basic_doc.php";

$data = array('page' => 'basic', 'menu' => array(
    'home' => 'Home', 'about' => 'About'
));
$view = new BasicDoc($data);

$view->show();
