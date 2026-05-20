<?php

session_start();

include '../config/database.php';

if(isset($_POST['action']) && $_POST['action'] == 'add'){

    $title = $_POST['title'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    $image_name = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];

    $folder = '../assets/img/' . $image_name;

    move_uploaded_file($tmp_name, $folder);

    mysqli_query(
        $conn,
        "INSERT INTO destinations
        (title, location, category, price, rating, description, image)
        VALUES
        ('$title','$location','$category','$price','$rating','$description','$image_name')"
    );

    header('Location: ../admin/manage.php');
    exit;

}



if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM destinations WHERE id='$id'"
    );

    header('Location: ../admin/manage.php');
    exit;
}
