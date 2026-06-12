<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$controller = new AuthController($conn);
$controller->index();

