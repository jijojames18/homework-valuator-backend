<?php
namespace Controller;
use Gateway/Questions;

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
            case 'GET':
                $result = $this->questions->getQuestionsForTest($this->testId);
                if (isset($result))
                {
                    $response = (
                        'status_code_header' => 'HTTP/1.1 200 OK',
                        'body' => $result
                    );
                }
                else
                {
                    $response = (
                        'status_code_header' => 'HTTP/1.1 404 Not Found',
                        'body' => null
                    );
                }
            break;
            default:
                $response = (
                    'status_code_header' => 'HTTP/1.1 404 Not Found',
                    'body' => null
                );
            break;
        }

        header($response['status_code_header']);
        if ($response['body'])
        {
            echo $response['body'];
        }
    }
}

