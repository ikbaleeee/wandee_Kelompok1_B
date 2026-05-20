<?php

session_start();

include '../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/loginregister.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Ulasan - Wandee</title>

  <!-- CSS -->

  <link
    rel="stylesheet"
    href="../assets/css/global.css">

  <link
    rel="stylesheet"
    href="../assets/css/user.css">

  <!-- FONT -->

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- LUCIDE -->

  <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="review-page">
  <?php include '../includes/navbar.php'; ?>


  <!-- ===================================== -->
  <!-- REVIEW -->
  <!-- ===================================== -->

  <main class="review-shell">

    <section class="review-layout-new">

      <div class="review-side">

        <h1>
          Beri Ulasan
        </h1>

        <p>
          Ceritakan perjalanan luar biasa kamu kepada komunitas penjelajah kami.
        </p>

        <article class="review-trip-preview">

          <div class="review-trip-image">
            <img src="../assets/img/bromo.png" alt="Pemandangan Bromo">
            <span>5.0</span>
          </div>

          <div>
            <small>
              <i data-lucide="map-pin"></i>
              Malang, Jawa Timur
            </small>

            <h2>
              Bromo & Malang
            </h2>

            <p>
              <i data-lucide="calendar-days"></i>
              01 Mei - 03 Mei
            </p>
          </div>

        </article>

        <blockquote class="review-quote">
          "Setiap perjalanan memiliki cerita. Kata-kata Anda dapat menginspirasi
          petualangan berikutnya bagi orang lain."
        </blockquote>

      </div>

      <section class="review-form-card review-form-card-new">

        <div class="review-form-head">

          <h2>
            Bagaimana pengalaman Anda?
          </h2>

          <p>
            Pilih rating Anda (1-5 bintang)
          </p>

        </div>

        <div class="rating-stars" aria-label="Pilih rating">

          <button type="button" aria-label="1 bintang" data-rating="1">
            <i data-lucide="star"></i>
          </button>

          <button type="button" aria-label="2 bintang" data-rating="2">
            <i data-lucide="star"></i>
          </button>

          <button type="button" aria-label="3 bintang" data-rating="3">
            <i data-lucide="star"></i>
          </button>

          <button type="button" aria-label="4 bintang" data-rating="4">
            <i data-lucide="star"></i>
          </button>

          <button type="button" aria-label="5 bintang" data-rating="5">
            <i data-lucide="star"></i>
          </button>

        </div>

        <form
          action="#"
          method="POST"
          enctype="multipart/form-data">

          <input type="hidden" name="rating" id="ratingValue" value="0">

          <div class="review-label-row">
            <label for="reviewText">
              Tulis ulasan Anda
            </label>

            <span>
              Maksimal 500 karakter
            </span>
          </div>

          <textarea
            id="reviewText"
            name="review"
            class="review-textarea"
            maxlength="500"
            placeholder="Bagikan detail tentang pemandu, akomodasi, pemandangan, dan lainnya..."></textarea>

          <label class="review-upload">
            <input type="file" name="review_photo" accept="image/png,image/jpeg">
            <span>
              <i data-lucide="upload-cloud"></i>
            </span>
            <strong>
              Klik untuk unggah atau seret foto ke sini
            </strong>
            <small>
              PNG, JPG (Maks. 5MB)
            </small>
          </label>

          <button
            type="submit"
            class="btn-primary review-submit">

            Kirim Ulasan
            <i data-lucide="send"></i>

          </button>

        </form>

      </section>

    </section>

  </main>
  <?php include '../includes/footer.php'; ?>

  <!-- JS -->

  <script src="../assets/js/script.js"></script>

</body>
</html>
