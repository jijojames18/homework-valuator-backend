<?php
namespace Gateway;

class Questions {
    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getQuestionsForTest($testId) {
        $statement = "
            SELECT 
                *
            FROM
                `questions`
            WHERE `test_id` = $testId;
        ";

        try {
            $statement = $this->db->query($statement);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}


?>