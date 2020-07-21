<?php
namespace Controller;

use Gateway\Response;

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
            case 'POST':
                $result = $this->response->insertResponseForTest($this->userId, $this->testId, json_decode($_POST['answers'], true));
                header('HTTP/1.1 201 CREATED');
            break;
            case 'GET':
                $result = $this->response->getResponseForTest($this->userId, $this->testId);
                if (isset($result) && !empty($result))
                {
                    header('HTTP/1.1 200 OK');
                    echo json_encode($result);
                    break;
                }
            default:
                header('HTTP/1.1 404 Not Found');
        }
    }
}