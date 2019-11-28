<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\Config\DatabaseConnector;

// $dotenv = new DotEnv(__DIR__);
// $dotenv->load();

$dbConnection = (new DatabaseConnector())->getConnection();

