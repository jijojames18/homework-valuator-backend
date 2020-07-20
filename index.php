<?php
require "src/index.php";

use Controller\QuestionController;
use Controller\AnswerController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[1] === 'question')
{
    $controller = new QuestionController($dbConnection, $requestMethod, $uri[2]);
    $controller->processRequest();
}
else if ($uri[1] === 'answer')
{
	$userId = null;
	if (isset($uri[3]))
	{
	    $userId = (int) $uri[3];
	}
	$testId = null;
	if (isset($uri[2]))
	{
	    $testId = (int) $uri[2];
	}
    $controller = new AnswerController($dbConnection, $requestMethod, $userId, $testId);
    $controller->processRequest();
}
else
{
    header("HTTP/1.1 404 Not Found");
    exit();
}