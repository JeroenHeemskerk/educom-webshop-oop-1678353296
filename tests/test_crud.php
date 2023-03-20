<?php
include_once('../cruds/crud.php');
$crud = new Crud();

$sql = "INSERT INTO users (email, name, password) VALUES ('test@lydia.nl', 'Lydia', 'new')";
//$sql = "UPDATE users SET password = 'testing' WHERE id = 13";
//$sql = "SELECT * from users WHERE email='test@lydia.nl'";
$params = array();
try {
    $result = $crud->readOneRow($sql, $params, $class = NULL);
    var_dump($result);
} catch (PDOException $e) {
    echo "test failed: " . $e->getMessage();
}
