<?php
namespace Gateway;

class Questions
{
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getQuestionsForTest($testId)
    {
        $test = $this->getTestDetails($testId);
        if (!isset($test) || empty($test))
        {
            return $test;
        }

        $statement = "
            SELECT
                *
            FROM
                `questions`
            WHERE
                `test_id` = :test_id
            ORDER BY `question_id` DESC;
        ";

        $questions = $this->executeQuery($statement, array(
            'test_id' => $testId
        ))->fetchAll(\PDO::FETCH_ASSOC);

        return array(
            'test' => $test[0],
            'questions' => $questions
        );
    }

    public function getTestDetails($testId)
    {
        $statement = "
            SELECT
                `test_end_time`
            FROM
                `tests`
            WHERE
                `test_id` = :test_id;

        ";

        return $this->executeQuery($statement, array(
            'test_id' => $testId
        ))->fetchAll(\PDO::FETCH_ASSOC);
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