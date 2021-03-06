<?php
namespace Gateway;

class Response
{
    private $db = null;
    private $questions = null;

    public function __construct($db, $questions)
    {
        $this->db = $db;
        $this->questions = $questions;
    }

    public function getResponseForTest($userId, $testId)
    {
        $responseId = $this->getResponseId($userId, $testId);

        if ($responseId !== 0)
        {
            $statement = "
                SELECT
                    *
                FROM
                    `answers`
                WHERE
                    `response_id`=:response_id;
            ";

            return $this->executeQuery($statement, array(
                'response_id' => $responseId
            ))->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    private function getResponseId($userId, $testId)
    {
        $statement = "
            SELECT
                `response_id`
            FROM
                `response`
            WHERE
                user_id=:user_id AND test_id=:test_id;
        ";

        $result = $this->executeQuery($statement, array(
            'user_id' => $userId,
            'test_id' => $testId
        ))->fetchAll(\PDO::FETCH_ASSOC);

        if (isset($result) && isset($result[0]))
        {
            return $result[0]['response_id'];
        }
        else
        {
            return 0;
        }
    }

    public function insertResponseForTest($userId, $testId, Array $answers)
    {
        $test = $this->questions->getTestDetails($testId);
        if (!isset($test) || empty($test))
        {
            return -1;
        }

        $testEndTime = $test[0]['test_end_time'];

        if (strtotime(date("Y-m-d H:i:s", time())) > strtotime($testEndTime))
        {
            return -2;
        }

        $insertedId = $this->getResponseId($userId, $testId);

        if ($insertedId === 0)
        {
            $this->insertRecord($userId, $testId, $answers);
        }
        else
        {
            $this->updateRecord($insertedId, $answers);
        }

        return 0;
    }

    private function updateRecord($responseId, $answers)
    {
        $statement = "
            UPDATE `answers`
            SET
                answer=:answer
            WHERE
                response_id=:response_id
            AND
                question_id=:question_id;
        ";

        foreach ($answers as $answer)
        {
            $this->executeQuery($statement, array(
                'response_id' => $responseId,
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer']
            ));
        }
    }

    private function insertRecord($userId, $testId, Array $answers)
    {
        $statement = "
            INSERT INTO `response`
                (`user_id`, `test_id`)
            VALUES
                (:user_id, :test_id);
        ";

        $this->executeQuery($statement, array(
            'user_id' => $userId,
            'test_id' => $testId
        ));
        $insertedId = $this->db->lastInsertId();

        $statement = "
            INSERT INTO `answers`
                (`response_id`, `question_id`, `answer`)
            VALUES
                (:response_id, :question_id, :answer);
        ";

        foreach ($answers as $answer)
        {
            $this->executeQuery($statement, array(
                'response_id' => $insertedId,
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer']
            ));
        }
    }

    private function executeQuery($query, $args)
    {
        try
        {
            $statement = $this->db->prepare($query);
            $statement->execute($args);
            return $statement;
        }
        catch(\PDOException $e)
        {
            exit($e->getMessage());
        }
    }
}