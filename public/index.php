<?php

session_start();

$config = require_once('../config.php');

require_once '../Controllers/FrontController.php';
require_once '../Controllers/CommentController.php';
require_once '../Controllers/UserController.php';
require_once '../Controllers/StoryController.php';
require_once '../Controllers/IndexController.php';

$framework = new FrontController($config, $_SERVER['REQUEST_URI'], $_SERVER['REDIRECT_BASE']);
echo $framework->execute();