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

$uriSize = sizeof($uri);

$questionIndex = array_search("questions", $uri);
$isQuestionRequest = $questionIndex !== null && $questionIndex === ($uriSize - 2);

$answerIndex = array_search("answers", $uri);
$isAnswerRequest = $answerIndex !== null && $answerIndex === ($uriSize - 3);

if ($isQuestionRequest)
{
    $testId = $uri[$uriSize - 1];
    $controller = (new QuestionController($dbConnection, $requestMethod, $uri[3]))->processRequest();
}
else if ($isAnswerRequest)
{
    $testId = (int) $uri[$uriSize - 2];
    $userId = (int) $uri[$uriSize - 1];
    $controller = (new AnswerController($dbConnection, $requestMethod, $userId, $testId))->processRequest();
}
else
{
    header("HTTP/1.1 404 Not Found");
    exit();
}
