<?php


namespace Upvote\Controllers;


use Upvote\Views\View;

class Controller
{
    /** @var \PDO $db */
    protected $db;
    /** @var View $view */
    protected $view;

    public function __construct($config)
    {
        $this->view = new View();
        $user = $config['database']['user'];
        $pass = $config['database']['pass'];
        $host = $config['database']['host'];
        $dbName = $config['database']['name'];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
        $this->createDbLink($dsn, $user, $pass);
    }

    protected function createDbLink($dsn, $user, $pass)
    {
        $this->db = new \PDO($dsn, $user, $pass);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

} 