<?PHP

// =================================================================
// Main App
// =================================================================

require_once("controllers/page-controller.php");
require_once("models/page-model.php");

session_start();

$pageModel = new PageModel(NULL);
$controller = new PageController($pageModel);
$controller->handleRequest();
