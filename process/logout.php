<?php

// Bridge to AuthController logout
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController($conn);
$auth->logout();

?>
