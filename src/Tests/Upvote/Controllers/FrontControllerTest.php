<?php

namespace Tests\Upvote\Controllers;

use Upvote\Controllers\FrontController;

class MasterControllerTest extends \PHPUnit_Framework_TestCase
{

    public static function determineController_UriAndRequestProvider()
    {
        return array(
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/',
                'controller'  => 'Index',
                'method'      => 'index',
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/user/login',
                'controller'  => 'User',
                'method'      => 'login',
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/story/create',
                'controller'  => 'Story',
                'method'      => 'create',
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/comment/create',
                'controller'  => 'Comment',
                'method'      => 'create',
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/user/logout',
                'controller'  => 'User',
                'method'      => 'logout',
            ),
        );
    }

    public static function executeController_UriAndRequestProvider()
    {
        return array(
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/mock/true',
                'result'      => true,
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/mock/false',
                'result'      => false,
            ),
            array(
                'base_uri'    => 'http://news.local',
                'request_uri' => 'http://news.local/mock/content',
                'result'      => 'testing',
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
     * @dataProvider determineController_UriAndRequestProvider
     */
    public function determineControllerAndMethod_ForApplicationConfig(
        $baseUri, $requestUri, $expectedController, $expectedMethod
    ) {
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
     * @dataProvider executeController_UriAndRequestProvider
     */
    public function executeControllerAndMethod($baseUri, $requestUri, $expectedResult)
    {
        $config = array(
            'routes' => array(
                'mock/true'    => 'mockController/mockTrueMethodAction',
                'mock/false'   => 'mockController/mockFalseMethodAction',
                'mock/content' => 'mockController/mockStringReturnAction',
            )
        );

        $controller = new FrontController($config, $requestUri, $baseUri);
        $result = $controller->execute();
        $this->assertEquals($expectedResult, $result);
    }
}


 