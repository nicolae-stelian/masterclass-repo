<?php

session_start();

$config = require_once('../config.php');

require_once '../controllers/MasterController.php';
require_once '../controllers/CommentController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/StoryController.php';
require_once '../controllers/IndexController.php';

$framework = new MasterController($config);
echo $framework->execute();