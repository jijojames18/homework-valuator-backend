<?php
namespace Controller;
use Gateway/Response;

class AnswerController
{

    private $db = null;
    private $requestMethod = null;
    private $userId = null;
    private $testId = null;
    private $response = null;

    public function __construct($db, $requestMethod, $userId, $testId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->testId = $testId;

        $this->response = new Response($db);
    }

    public function processRequest()
    {
        $response = array();

        switch ($this->requestMethod)
        {
            case 'GET':
                $result = $this->response->getResponseForTest($this->userId, $this->testId);
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
            case 'POST':
                $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                $result = $this->response->getQuestionsForTest($input);
                $response = (
                    'status_code_header' => 'HTTP/1.1 201 CREATED',
                    'body' => null
                );
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

