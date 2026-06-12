<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/BookingModel.php';
require_once __DIR__ . '/../app/models/PaymentModel.php';

session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: ../auth/loginregister.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$bookingModel = new BookingModel($conn);
$paymentModel = new PaymentModel($conn);

if($action === 'init'){
    $destination_id = isset($_POST['destination_id']) ? (int)$_POST['destination_id'] : 0;
    $people = isset($_POST['total_people']) ? max(1, (int)$_POST['total_people']) : 1;
    $method = $_POST['payment_method'] ?? '';

    if($destination_id <= 0 || !$method){
        header('Location: ../user/payment.php?id=' . $destination_id);
        exit;
    }

    $dest = mysqli_query($conn, "SELECT * FROM destinations WHERE id='" . $destination_id . "' LIMIT 1");
    $destination = $dest ? mysqli_fetch_assoc($dest) : null;

    if(!$destination){
        header('Location: ../index.php');
        exit;
    }

    $price = (int)$destination['price'];
    $total_price = $price * $people;
    $unique_code = '';

    $booking_id = $bookingModel->create([
        'user_id' => $user_id,
        'destination_id' => $destination_id,
        'total_people' => $people,
        'total_price' => $total_price,
        'payment_status' => 'pending',
        'trip_status' => 'new'
    ]);

    $payment_id = $paymentModel->create([
        'booking_id' => $booking_id,
        'payment_method' => $method,
        'payment_amount' => $total_price,
        'unique_code' => $unique_code,
        'payment_status' => 'waiting'
    ]);

    header('Location: ../user/payment_detail.php?booking_id=' . $booking_id . '&payment_id=' . $payment_id);
    exit;
}

if($action === 'upload_proof'){
    $payment_id = isset($_POST['payment_id']) ? (int)$_POST['payment_id'] : 0;
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $payment = $paymentModel->findById($payment_id);
    $booking = $bookingModel->findById($booking_id);

    if(!$payment || !$booking || $booking['user_id'] !== $user_id || $payment['booking_id'] !== $booking['id']){
        header('Location: ../user/profile.php');
        exit;
    }

    if(!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK){
        header('Location: ../user/payment_detail.php?booking_id=' . $booking_id . '&payment_id=' . $payment_id);
        exit;
    }

    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    $mime = mime_content_type($_FILES['payment_proof']['tmp_name']);
    if(!in_array($mime, $allowed, true) || $_FILES['payment_proof']['size'] > 5 * 1024 * 1024){
        header('Location: ../user/payment_detail.php?booking_id=' . $booking_id . '&payment_id=' . $payment_id);
        exit;
    }

    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\.\-]/', '_', basename($_FILES['payment_proof']['name']));
    $destFolder = __DIR__ . '/../public/uploads/payments/';
    if(!is_dir($destFolder)) mkdir($destFolder, 0755, true);
    move_uploaded_file($_FILES['payment_proof']['tmp_name'], $destFolder . $filename);
    $paymentModel->updateProof($payment_id, $filename);

    header('Location: ../user/payment_status.php?booking_id=' . $booking_id);
    exit;
}

if($action === 'admin_update'){
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('Location: ../auth/loginregister.php');
        exit;
    }

    $payment_id = isset($_POST['payment_id']) ? (int)$_POST['payment_id'] : 0;
    $status = $_POST['status'] ?? '';
    $valid = ['verified','rejected'];

    if($payment_id && in_array($status, $valid, true)){
        $paymentModel->updateStatus($payment_id, $status);
        $payment = $paymentModel->findById($payment_id);
        if($payment){
            $bookingModel->updatePaymentStatus($payment['booking_id'], $status === 'verified' ? 'paid' : 'pending');
            if($status === 'verified'){
                $bookingModel->updateTripStatus($payment['booking_id'], 'ongoing');
            }
        }
    }

    header('Location: ../admin/manage_payments.php');
    exit;
}

header('Location: ../user/profile.php');
exit;
