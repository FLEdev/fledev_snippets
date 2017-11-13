<?php

define('BASE_PATH_DIR', __DIR__ . '/..');
use Helper\RequestHelper;

require BASE_PATH_DIR . '/vendor/autoload.php';

$request = new RequestHelper();
echo $request->processRequest();