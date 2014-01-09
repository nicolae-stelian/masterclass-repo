<?php


namespace Tests\Upvote\Controllers;


use Upvote\Controllers\IndexController;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockIndexController
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
        $this->controller = new MockIndexController($config);
    }


    public function testGetAllStories()
    {
        $stories = array();

        $StmtStub = $this->getMock('PDOStatement');
        $StmtStub->expects($this->at(0))
            ->method('fetchAll')
            ->will($this->returnValue($stories));

        $StmtStub->expects($this->at(1))
            ->method('execute');

        $pdoStub = $this->getMockBuilder('mockPDO')
            ->disableOriginalConstructor()
            ->setMethods(array("prepare"))
            ->getMock();

        $pdoStub->expects($this->at(0))
            ->method('prepare')
            ->with('SELECT * FROM story ORDER BY created_on DESC')
            ->will($this->returnValue($StmtStub));

        $this->controller->setPdo($pdoStub);
        $this->controller->getAllStories();
    }

    public function testCountComments()
    {
        $comments = array();

        $StmtStub = $this->getMock('PDOStatement');
        $StmtStub->expects($this->at(1))
            ->method('fetch')
            ->will($this->returnValue($comments));

        $StmtStub->expects($this->at(0))
            ->method('execute')
            ->with(array(3));

        $pdoStub = $this->getMockBuilder('mockPDO')
            ->disableOriginalConstructor()
            ->setMethods(array("prepare"))
            ->getMock();

        $pdoStub->expects($this->at(0))
            ->method('prepare')
            ->with('SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?')
            ->will($this->returnValue($StmtStub));

        $this->controller->setPdo($pdoStub);
        $this->controller->countComments(array('id' => 3));
    }
}

class MockIndexController extends IndexController
{
    public function setPdo($pdo)
    {
        $this->db = $pdo;
    }

    protected function createDbLink()
    {}
}
 