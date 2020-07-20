<?php
require 'bootstrap.php';
use Database\DatabaseConnector;

$dbConnection = (new DatabaseConnector())->getConnection();
?>