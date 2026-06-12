<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$controller = new AdminController($conn);
$controller->manage();
