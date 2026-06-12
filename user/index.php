<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

$controller = new UserController($conn);
$controller->index();
