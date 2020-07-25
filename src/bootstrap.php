<?php
use Dotenv\Dotenv;

if (getenv('APP_ENV') !== 'production')
{
    $dotenv = new Dotenv(__DIR__.'/../../');
    $dotenv->load();
}

define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));