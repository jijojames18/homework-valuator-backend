<?php
namespace Controller;

class QuestionController {

    public function __construct($requestMethod){

    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                break;
            default:
                break;
        }
    }
}