<?php

include '../config/database.php';

$id = $_POST['id'];

$title = $_POST['title'];
$location = $_POST['location'];
$category = $_POST['category'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$description = $_POST['description'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM destinations WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

$image = $data['image'];


if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){

    $image = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/img/" . $image
    );
}

mysqli_query(
    $conn,
    "UPDATE destinations SET

    title='$title',
    location='$location',
    category='$category',
    price='$price',
    rating='$rating',
    description='$description',
    image='$image'

    WHERE id='$id'"
);


header('Location: ../admin/manage.php');
exit;

?>
