<?php

define('DIR', __DIR__);
require DIR . '/vendor/autoload.php';

$app = new Kappa\App;

$app->run();