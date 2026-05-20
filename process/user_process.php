<?php

session_start();

include '../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/loginregister.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$action = $_POST['action'];


// =====================================
// UPDATE PROFILE
// =====================================

if($action == 'update_profile'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    // =====================================
    // GET OLD DATA
    // =====================================

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id='$user_id'"
    );

    $user = mysqli_fetch_assoc($query);


    // =====================================
    // PHOTO UPLOAD
    // =====================================

    $photo_name = $user['photo'];

    if(!empty($_FILES['photo']['name'])){

        $file_name = $_FILES['photo']['name'];

        $tmp_name = $_FILES['photo']['tmp_name'];

        $new_name = time() . '_' . $file_name;

        move_uploaded_file(
            $tmp_name,
            "../assets/uploads/profile/" . $new_name
        );

        $photo_name = $new_name;

    }


    // =====================================
    // UPDATE PASSWORD
    // =====================================

    if(!empty($password)){

        $password = md5($password);

        mysqli_query(
            $conn,
            "UPDATE users SET

            name='$name',
            email='$email',
            password='$password',
            photo='$photo_name'

            WHERE id='$user_id'"
        );

    } else {

        mysqli_query(
            $conn,
            "UPDATE users SET

            name='$name',
            email='$email',
            photo='$photo_name'

            WHERE id='$user_id'"
        );

    }


    // =====================================
    // UPDATE SESSION
    // =====================================

    $_SESSION['name'] = $name;


    // =====================================
    // REDIRECT
    // =====================================

    header("Location: ../user/profile.php");

}

?>
