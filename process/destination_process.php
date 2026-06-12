<?php

// Bridge to new DestinationController
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/DestinationController.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

$ctrl = new DestinationController($conn);

if($action === 'add' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && !isset($_POST['id']))){
    $ctrl->add();
}

if($action === 'update' || (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] === 'POST')){
    $ctrl->update();
}

if(isset($_GET['delete']) || $action === 'delete'){
    $ctrl->delete();
}
