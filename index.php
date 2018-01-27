<?php

// Autoloader
spl_autoload_register(function ($name) {
    $fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';

    if (file_exists($fileName)) {
        require_once $fileName;
    }
});

$config = Config::getInstance();
$defaultController = $config->getConfig("defaultController");
$defaultAction = $config->getConfig("defaultAction");

// Extract URL parameters
$controllerParameter = isset($_GET["c"]) ? $_GET["c"] : $defaultController;
$actionParameter = isset($_GET["a"]) ? $_GET["a"] : $defaultAction;

// Controller and action naming conventions
// Controllers must use namespace "\Controllers"
// Class name must end with "...Controller"
// Method name must end with "...Action"
$controllerClassName = "\\Controllers\\" . ucfirst($controllerParameter) . "Controller";
$actionMethodName = lcfirst($actionParameter) . "Action";

try {
    if (!class_exists($controllerClassName)) {
        throw new Exception("Controller not found");
    }

    // Create Controller
    $controller = new $controllerClassName;

    if (!method_exists($controller, $actionMethodName)) {
        throw new Exception("Action not found");
    }

    // Create view and render it
    $view = new \Views\View(ucfirst($controllerParameter), lcfirst($actionParameter));
    $controller->setView($view);

    // Call desired action
    $controller->$actionMethodName();

    // Render view
    $view->render();
} catch (Exception $e) {
    http_response_code(404);
    echo $e->getMessage();
}

