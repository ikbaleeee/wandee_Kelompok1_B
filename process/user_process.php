<?php

// Bridge to new UserController
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

$ctrl = new UserController($conn);

if($action === 'update_profile'){
    $ctrl->update_profile();
}
