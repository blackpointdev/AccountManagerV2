<?php
require "../bootstrap.php";
use Src\Controller\UserController;
use Src\Controller\OperationController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] === 'api')
{
    if ($uri[2] === 'operation')
    {
        $controller = new OperationController($dbConnection);
    }
//    elseif($uri[2] === 'user')
//    {
//        $controller = new UserController($dbConnection);
//    }
    else
    {
        echo "Błąd";
        //header("HTTP/1.1 404 Not Found");
        exit();
    }
}
else
{
    echo "Błąd";
    //header("HTTP/1.1 404 Not Found");
    exit();
}

//TODO Refactoring, create routing table

// Set missing controller parameters
$controller->setRequestMethod($_SERVER["REQUEST_METHOD"]);
if (isset($uri[3]))
{
    $controller->setTargetId($uri[3]);
}

$controller->processRequest();
