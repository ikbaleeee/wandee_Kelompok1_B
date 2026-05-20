<?php

include '../config/database.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM destinations WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Edit Destinasi</title>

  <link
    rel="stylesheet"
    href="../assets/css/global.css">

</head>

<body>

<div
  style="
    max-width:700px;
    margin:50px auto;
    background:#fff;
    padding:30px;
    border-radius:20px;
  "
>

<h1>Edit Destinasi</h1>

<form
  action="../process/update_destination.php"
  method="POST"
  enctype="multipart/form-data"
  style="display:grid;gap:16px;"
>

<input
  type="hidden"
  name="id"
  value="<?php echo $data['id']; ?>"
>

<input
  type="text"
  name="title"
  value="<?php echo $data['title']; ?>"
>

<input
  type="text"
  name="location"
  value="<?php echo $data['location']; ?>"
>

<input
  type="text"
  name="category"
  value="<?php echo $data['category']; ?>"
>

<input
  type="text"
  name="price"
  value="<?php echo $data['price']; ?>"
>

<input
  type="text"
  name="trip_date"
  value="<?php echo $data['trip_date']; ?>"
>

<input
  type="number"
  step="0.1"
  name="rating"
  value="<?php echo $data['rating']; ?>"
>

<textarea name="description"><?php echo $data['description']; ?></textarea>

<input
  type="file"
  name="image"
>

<button
  type="submit"
  class="btn-primary"
>

  Update Destinasi

</button>

</form>

</div>

</body>
</html>
