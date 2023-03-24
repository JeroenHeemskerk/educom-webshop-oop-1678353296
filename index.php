<?PHP

// =================================================================
// Main App
// =================================================================

require_once("cruds/crud.php");
require_once("models/page-model.php");
require_once("controllers/page-controller.php");

session_start();

$crud = new Crud();
$pageModel = new PageModel(NULL, $crud);
$controller = new PageController($pageModel);
$controller->handleRequest();
