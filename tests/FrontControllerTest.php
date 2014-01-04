<?php

require_once 'bootstrap.php';

class MasterControllerTest extends PHPUnit_Framework_TestCase
{

    public static function uriProvider()
    {
        return array(
            array (
                'http://news.local',
                'http://news.local/' ,
                'Index',
                'index',
            ),
            array (
                'http://news.local',
                'http://news.local/user/login' ,
                'User',
                'login',
            ),
            array (
                'http://news.local',
                'http://news.local/story/create' ,
                'Story',
                'create',
            ),
            array (
                'http://news.local',
                'http://news.local/comment/create' ,
                'Comment',
                'create',
            ),
            array (
                'http://news.local',
                'http://news.local/user/logout' ,
                'User', 'logout',
            ),
        );
    }

    /**
     * @test
     */
    public function determineControllerAnd_WhenConfigIsEmpty()
    {
        $config = array('routes' => array());
        $controller = new FrontController($config);
        $actualController = $controller->getController();
        $actualMethod = $controller->getMethod();
        $this->assertEquals('', $actualController);
        $this->assertEquals('', $actualMethod);
    }

    /**
     * @test
     * @dataProvider uriProvider
     */
    public function determineControllerAndMethod_ForApplicationConfig($baseUri, $requestUri, $expectedController, $expectedMethod)
    {
        $config = array(
            'routes' => array(
                ''               => 'index/index',
                'story'          => 'story/index',
                'story/create'   => 'story/create',
                'comment/create' => 'comment/create',
                'user/create'    => 'user/create',
                'user/account'   => 'user/account',
                'user/login'     => 'user/login',
                'user/logout'    => 'user/logout',
            ),
        );

        $controller = new FrontController($config, $requestUri, $baseUri);
        $actualController = $controller->getController();
        $actualMethod = $controller->getMethod();
        $this->assertEquals($expectedController, $actualController);
        $this->assertEquals($expectedMethod, $actualMethod);
    }

    /**
     * @test
     */
    public function executeControllerAndMethod()
    {
    }
}

//class MockController
//{
//    public function mockTrueMethodAction()
//    {
//        return true;
//    }
//
//    public function mockFalseMethodAction()
//    {
//        return false;
//    }
//}
 