<?php
namespace Controller;

use Gateway\Questions;

class QuestionController
{

    private $db = null;
    private $requestMethod = null;
    private $testId = null;
    private $questions = null;

    public function __construct($db, $requestMethod, $testId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->testId = $testId;

        $this->questions = new Questions($db);
    }

    public function processRequest()
    {
        $response = array();

        switch ($this->requestMethod)
        {
            case 'OPTIONS':
                 if (
                    isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
                    $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET' &&
                    isset($_SERVER['HTTP_ORIGIN']) &&
                    is_approved($_SERVER['HTTP_ORIGIN'])
                )
                {
                    header('HTTP/1.1 200 OK');
                }
                else
                {
                    header('HTTP/1.1 404 Not Found');
                }
                break;
            case 'GET':
                $result = $this->questions->getQuestionsForTest($this->testId);
                if (isset($result) && !empty($result))
                {
                    header('HTTP/1.1 200 OK');
                    echo json_encode($result);
                    break;
                }
            default:
                header('HTTP/1.1 404 Not Found');
            break;
        }
    }
}