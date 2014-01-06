<?php


class CommentController
{

    /** @var \PDO $db */
    protected $db;

    public function __construct($config)
    {
        $user = $config['database']['user'];
        $pass = $config['database']['pass'];
        $host = $config['database']['host'];
        $dbName = $config['database']['name'];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
        $this->createDbLink($dsn, $user, $pass);

    }

    public function create()
    {
        if (!$this->isAuthenticated()) {
           throw new UserNotAuthenticatedException();
        }

        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                 $this->getUserName(),
                 $this->getStoryId(),
                 $this->validatePost('comment'),
            )
        );
        header("Location: /story/?id=" . $this->getStoryId());
    }

    protected function isAuthenticated()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            return false;
        }
        return true;
    }

    protected function createDbLink($dsn, $user, $pass)
    {
        $this->db = new PDO($dsn, $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function getUserName()
    {
        return $_SESSION['username'];
    }

    /**
     * @return mixed
     */
    protected function getStoryId()
    {
        return $_POST['story_id'];
    }

    /**
     * @return mixed
     */
    protected function validatePost($field)
    {
        return filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}

class UserNotAuthenticatedException extends Exception{

};