<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/ReviewModel.php';

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../auth/loginregister.php');
    exit;
}

$action = $_POST['action'] ?? '';
$model = new ReviewModel($conn);

if($action === 'delete'){
    $review_id = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
    if($review_id > 0){
        $model->deleteById($review_id);
    }
}

header('Location: ../admin/manage_reviews.php');
exit;
