<?php
require 'src/index.php';

use Controller\QuestionController;
use Controller\AnswerController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$controllerMethod = $uri[3];

if ($controllerMethod === 'questions')
{
    $controller = (new QuestionController($dbConnection, $requestMethod, $uri[4]))->processRequest();
}
else if ($controllerMethod === 'answers')
{
	$testId = null;
	$userId = null;

	if (isset($uri[4]))
	{
	    $testId = (int) $uri[4];
	}

	if (isset($uri[5]))
	{
	    $userId = $uri[5];
	}

    $controller = (new AnswerController($dbConnection, $requestMethod, $userId, $testId))->processRequest();
}
else
{
    header("HTTP/1.1 404 Not Found");
    exit();
}