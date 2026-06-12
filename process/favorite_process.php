<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/FavoriteModel.php';

session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: ../auth/loginregister.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$model = new FavoriteModel($conn);

if($action === 'toggle'){
    $destination_id = isset($_POST['destination_id']) ? (int)$_POST['destination_id'] : 0;
    if($destination_id <= 0){
        header('Location: ../user/detail.php?id=' . $destination_id);
        exit;
    }

    if($model->isFavorite($user_id, $destination_id)){
        $model->remove($user_id, $destination_id);
    } else {
        $model->add($user_id, $destination_id);
    }

    header('Location: ../user/detail.php?id=' . $destination_id);
    exit;
}

header('Location: ../user/favorite.php');
exit;
