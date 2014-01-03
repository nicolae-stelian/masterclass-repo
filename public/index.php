<?php

session_start();

$config = require_once('../config.php');

require_once '../Controllers/MasterController.php';
require_once '../Controllers/CommentController.php';
require_once '../Controllers/UserController.php';
require_once '../Controllers/StoryController.php';
require_once '../Controllers/IndexController.php';

$framework = new MasterController($config);
echo $framework->execute();