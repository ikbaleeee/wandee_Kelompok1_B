<?php
// Front controller: load config and route request
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(300);

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Router.php';

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$router = new Router($basePath);
$router->dispatch();

?>
