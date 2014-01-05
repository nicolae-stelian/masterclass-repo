<?php

require_once 'bootstrap.php';


class CommentControllerTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        $config = '';
        $controller = new CommentController($config);
        $this->assertTrue(true);
    }
}
 