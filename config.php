<?php

return array(

    'database' => array(
        'user' => 'root',
        'pass' => '',
        'host' => 'localhost',
        'name' => 'masteroop',
    ),

    'routes' => array(
        ''               => 'indexController/index',
        'story'          => 'storyController/index',
        'story/create'   => 'storyController/create',
        'comment/create' => 'commentController/create',

        'user/create'    => 'userController/create',
        'user/account'   => 'userController/account',
        'user/login'     => 'userController/login',
        'user/logout'    => 'userController/logout',
    ),
);
