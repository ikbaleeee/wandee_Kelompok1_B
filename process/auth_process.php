<?php

session_start();

include '../config/database.php';

$action = $_POST['action'];

// REGISTER

if($action == 'register'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // CHECK EMAIL

    $check = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0){

        echo "Email sudah digunakan";
        exit;

    }

    // INSERT USER

    mysqli_query(
        $conn,
        "INSERT INTO users(name,email,password)
        VALUES('$name','$email','$password')"
    );

    header("Location: ../auth/loginregister.php");
    exit;

}

// LOGIN

if($action == 'login'){

    $email = $_POST['email'];
    $password = md5($password = $_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE email='$email'
        AND password='$password'"
    );

    $user = mysqli_fetch_assoc($query);

    if($user){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // ADMIN

        if($user['role'] == 'admin'){

            header("Location: ../admin/dashboard.php");
            exit;

        }

        // USER

        else {

            header("Location: ../user/index.php");
            exit;

        }

    }

    else {

        echo "Email atau password salah";

    }

}

?>
