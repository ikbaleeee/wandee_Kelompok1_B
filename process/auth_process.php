<?php

// Bridge: gunakan AuthController dari app/controllers
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$action = $_POST['action'] ?? '';

$auth = new AuthController($conn);

if($action === 'register'){
    $auth->register();
} elseif($action === 'login'){
    $auth->login();
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid action';
}

?>
