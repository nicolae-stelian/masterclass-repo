<?php
session_start();

require_once __DIR__ . '/../src/autoload.php';
$config = require_once __DIR__ . '/../config.php';

$framework = new \Upvote\Controllers\FrontController($config, $_SERVER['REQUEST_URI'], $_SERVER['REDIRECT_BASE']);
echo $framework->execute();