<?php

require_once('core\autoload.php');


new autoload();

$router = new \core\Utility\Router();


/** Gỡ lỗi */
error_reporting(E_ALL);
set_error_handler('core\Utility\ErrorHandler::errorHandler');
set_exception_handler('core\Utility\ErrorHandler::exceptionHandler');


/**
 * Router gồm các tham số
 *
 * $controller      Tên controller
 * $action          Tên phương thức trong controller
 * $namespace       Tên namespace của controller. VD: 'namespace' => 'Admin'
 */

//$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
// Router với regex
//$router->add('{controller}/{id:\d+}/{action}');

$router->add('', ['controller' => 'PublicController', 'action' => 'index']);



$router->dispatch($_SERVER['QUERY_STRING']);

