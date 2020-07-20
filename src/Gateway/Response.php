<?php
namespace Gateway;

class Questions {    
    
    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertResponseForTest(Array $input) {
        $inserted_id = 0;

        $statement = "
            INSERT INTO `response`
                (`user_id`, `test_id`)
            VALUES
                (:user_id, :test_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user_id' => $input['user_id'],
                'test_id'  => $input['test_id']
            ));
            $inserted_id = $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        $statement = "
            INSERT INTO `answers`
                (`response_id`, `question_id`, `answer`)
            VALUES
                (:response_id, :question_id, :answer);
        ";

        $statement = $this->db->prepare($statement);

        $answers = $input['answers'];
        foreach ($answers as $answer) {
            try {
                $statement->execute(array(
                    'response_id' => $inserted_id,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer']
                ));
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
    }

    public function getResponseForTest($user_id, $test_id) {
        $response_id = 0;

        $statement = "
            SELECT
                `response_id`
            FROM
                `response`
            WHERE
                `user_id`='$user_id' AND `test_id`=$test_id;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if (isset($result) && isset($result[0])) {
                $response_id = $result[0]['response_id'];
            }
            else {
                return 0;
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        $statement = "
            SELECT
                *
            FROM
                `answers`
            WHERE
                `response_id`=$response_id;
        ";

        try {
            $statement = $this->db->query($statement);
            return $ths->db->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

?>