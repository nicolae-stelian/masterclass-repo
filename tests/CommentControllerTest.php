<?php

require_once 'bootstrap.php';


class CommentControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockCommentController
     */
    protected $controller;

    protected function setUp()
    {
        $config = array('database' => array(
            'user' => 'user',
            'pass' => 'pass',
            'host' => 'host',
            'name' => 'name',
        ));
        $this->controller = new MockCommentController($config);
    }

    /**
     * @test
     * @expectedException UserNotAuthenticatedException
     */
    public function create_WhenUserIsNotLogged_MustThrowException()
    {
        $this->controller->setAuthenticated(false);
        $this->controller->create();
    }

    /**
     * @test
     */
    public function create_WhenUserIsLoggedIn_MustInsertInDatabase()
    {
        $this->controller->setAuthenticated(true);

        $StmtStub = $this->getMock('PDOStatement');
        $StmtStub->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(''));

        $pdoStub = $this->getMockBuilder('mockPDO')
            ->disableOriginalConstructor()
            ->setMethods(array("prepare"))
            ->getMock();

        $pdoStub->expects($this->any())
            ->method('prepare')
            ->will($this->returnValue($StmtStub));

        $this->controller->setPdo($pdoStub);
        $this->controller->create();
    }



}

class MockCommentController extends CommentController
{
    protected $authenticated = true;


    protected function isAuthenticated()
    {
        return $this->authenticated;
    }


    public function setAuthenticated($authenticated)
    {
        $this->authenticated = (bool) $authenticated;
    }

    public function createDbLink()
    {}

    public function setPdo($pdo)
    {
        $this->db =  $pdo;
    }

    protected function getUserName()
    {
        return 'CommentUser';
    }

    protected function getStoryId()
    {
        return 312;
    }

    protected function validatePost($field)
    {
        return $field . ' is validated';
    }

}
 