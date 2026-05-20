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

  <title>Favorit - Wandee</title>

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

<body class="favorite-page">
  <?php include '../includes/navbar.php'; ?>


  <!-- FAVORITE -->

  <section class="favorite-wrap">

    <!-- HERO -->

    <div class="favorite-hero">

      <span class="favorite-kicker">

        <i data-lucide="heart"></i>

        Destinasi Favorit

      </span>


      <h1>
        Perjalanan Favorit
      </h1>

      <p>
        Semua destinasi impian yang kamu simpan
        untuk perjalanan berikutnya bersama Wandee.
      </p>

    </div>


    <!-- GRID -->

    <div class="favorite-grid">


      <!-- CARD 1 -->

      <div class="favorite-card">

        <div class="favorite-thumb">

          <img
            src="../assets/img/bromo.png"
            alt="Bromo">


          <span class="favorite-country">
            Indonesia
          </span>


          <button class="favorite-heart">

            <i data-lucide="heart"></i>

          </button>

        </div>


        <div class="favorite-body">

          <h3>
            Bromo & Malang
          </h3>

          <p>
            Nikmati keindahan sunrise Gunung
            Bromo dan eksplorasi kota Malang.
          </p>


          <div class="favorite-price">

            <strong>
              Rp 3jt
            </strong>


            <a
              href="detail.php"
              class="favorite-detail">

              Lihat Detail

              <i data-lucide="arrow-right"></i>

            </a>

          </div>

        </div>

      </div>



      <!-- CARD 2 -->

      <div class="favorite-card">

        <div class="favorite-thumb">

          <img
            src="../assets/img/rajaampat.png"
            alt="Raja Ampat">


          <span class="favorite-country">
            Indonesia
          </span>


          <button class="favorite-heart">

            <i data-lucide="heart"></i>

          </button>

        </div>


        <div class="favorite-body">

          <h3>
            Raja Ampat
          </h3>

          <p>
            Jelajahi surga bawah laut terbaik
            dengan panorama laut eksotis.
          </p>


          <div class="favorite-price">

            <strong>
              Rp 8jt
            </strong>


            <a
              href="detail.php"
              class="favorite-detail">

              Lihat Detail

              <i data-lucide="arrow-right"></i>

            </a>

          </div>

        </div>

      </div>


      <!-- CARD 3 -->

      <div class="favorite-card">

        <div class="favorite-thumb">

          <img
            src="../assets/img/merbabu.png"
            alt="Merbabu">


          <span class="favorite-country">
            Indonesia
          </span>


          <button class="favorite-heart">

            <i data-lucide="heart"></i>

          </button>

        </div>


        <div class="favorite-body">

          <h3>
            Gunung Merbabu
          </h3>

          <p>
            Pendakian seru dengan pemandangan
            sabana yang memukau.
          </p>


          <div class="favorite-price">

            <strong>
              Rp 2.5jt
            </strong>


            <a
              href="detail.php"
              class="favorite-detail">

              Lihat Detail

              <i data-lucide="arrow-right"></i>

            </a>

          </div>

        </div>

      </div>

    </div>


    <!-- ADD MORE -->

    <div class="favorite-add">

      <div>

        <i
          data-lucide="plus-circle"
          style="margin:auto; margin-bottom:14px;"></i>

        <p>
          Tambahkan lebih banyak destinasi favorit
        </p>

      </div>

    </div>

  </section>
  <?php include '../includes/footer.php'; ?>

  <!-- JS -->

  <script src="../assets/js/script.js"></script>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
