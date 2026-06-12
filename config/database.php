<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "wandee"
);

if(!$conn){

    die("Koneksi database gagal");

}

$checkProvider = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'oauth_provider'");
if (mysqli_num_rows($checkProvider) === 0) {
    mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `oauth_provider` VARCHAR(50) DEFAULT NULL AFTER `photo`");
}

$checkUid = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'oauth_uid'");
if (mysqli_num_rows($checkUid) === 0) {
    mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `oauth_uid` VARCHAR(255) DEFAULT NULL AFTER `oauth_provider`");
}

?>
