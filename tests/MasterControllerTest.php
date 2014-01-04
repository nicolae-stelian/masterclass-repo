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
                array('call' =>array('index', 'index')),
            ),
            array (
                'http://news.local',
                'http://news.local/user/login' ,
                array('call' =>array('user', 'login')),
            ),
            array (
                'http://news.local',
                'http://news.local/story/create' ,
                array('call' =>array('story', 'create')),
            ),
            array (
                'http://news.local',
                'http://news.local/comment/create' ,
                array('call' =>array('comment', 'create')),
            ),
            array (
                'http://news.local',
                'http://news.local/user/logout' ,
                array('call' =>array('user', 'logout')),
            ),
        );
    }

    /**
     * @test
     */
    public function determineController_WhenConfigIsEmpty()
    {
        $config = array('routes' => array());
        $controller = new MasterController($config);
        $actual = $controller->determineControllers();
        $this->assertEquals(array(), $actual);
    }

    /**
     * @test
     */
    public function determineController_WhenHaveRedirectBaseAndEmptyConfig()
    {
        $config = array('routes' => array());
        $controller = new MasterController($config, 'http://news.local/user/login', 'http://news.local');
        $actual = $controller->determineControllers();
        $this->assertEquals(array(), $actual);
    }


    /**
     * @test
     * @dataProvider uriProvider
     */
    public function determineController_WhenAllMatchesAreOk($baseUri, $requestUri, $expected)
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

        $controller = new MasterController($config, $requestUri, $baseUri);
        $actual = $controller->determineControllers();
        $this->assertEquals($expected, $actual);
    }
}
 