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
        $statement = "
            SELECT
                *
            FROM
                `questions`
            WHERE `test_id` = :test_id
            ORDER BY `question_id` DESC;
        ";

        try
        {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'test_id' => $testId
            ));
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            exit($e->getMessage());
        }
    }
}