<?php
require 'bootstrap.php';
require 'autoload.php';

use Database\DatabaseConnector;

$dbConnection = (new DatabaseConnector())->getConnection();