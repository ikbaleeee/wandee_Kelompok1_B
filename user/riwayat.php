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

  <title>Riwayat Perjalanan - Wandee</title>

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

<body class="trip-page">
  <?php include '../includes/navbar.php'; ?>


  <!-- RIWAYAT -->

  <section class="trip-wrap">


    <!-- HERO -->

    <div class="trip-hero">

      <span class="trip-kicker">

        <i data-lucide="clock-3"></i>

        Riwayat Perjalanan

      </span>


      <h1>
        Riwayat Perjalanan Saya
      </h1>

      <p>
        Semua perjalanan yang pernah kamu
        ikuti bersama Wandee tersimpan di sini.
      </p>

    </div>



    <!-- CARD 1 -->

    <div class="trip-history-card">


      <!-- IMAGE -->

      <img
        src="../assets/img/bromo.png"
        alt="Bromo">


      <!-- INFO -->

      <div class="trip-history-info">

        <h3>
          Bromo & Malang
        </h3>

        <p>
          Open trip eksplorasi sunrise Gunung
          Bromo dan wisata kota Malang.
        </p>

        <br>

        <p>
          📅 01 Mei - 03 Mei 2026
        </p>

        <p>
          👥 4 Peserta
        </p>

        <p>
          📍 Jawa Timur, Indonesia
        </p>

      </div>


      <!-- ACTION -->

      <div class="trip-history-action">

        <span class="trip-status">
          Completed
        </span>


        <div style="display:flex; gap:10px;">

          <a
            href="detail.php"
            class="btn-primary">

            Lihat Detail
          </a>


          <a
            href="ulasan.php"
            class="btn-ghost">

            Beri Ulasan
          </a>

        </div>

      </div>

    </div>



    <!-- CARD 2 -->

    <div class="trip-history-card">


      <!-- IMAGE -->

      <img
        src="../assets/img/rajaampat.png"
        alt="Raja Ampat">


      <!-- INFO -->

      <div class="trip-history-info">

        <h3>
          Raja Ampat
        </h3>

        <p>
          Eksplorasi surga bawah laut terbaik
          Indonesia dengan pengalaman premium.
        </p>

        <br>

        <p>
          📅 10 Mei - 15 Mei 2026
        </p>

        <p>
          👥 2 Peserta
        </p>

        <p>
          📍 Papua Barat, Indonesia
        </p>

      </div>


      <!-- ACTION -->

      <div class="trip-history-action">

        <span class="trip-status">
          Upcoming
        </span>


        <div style="display:flex; gap:10px;">

          <a
            href="payment.php"
            class="btn-primary">

            Pembayaran
          </a>


          <a
            href="detail.php"
            class="btn-ghost">

            Lihat Detail
          </a>

        </div>

      </div>

    </div>

    <!-- CARD 3 -->

    <div class="trip-history-card">


      <!-- IMAGE -->

      <img
        src="../assets/img/merbabu.png"
        alt="Merbabu">


      <!-- INFO -->

      <div class="trip-history-info">

        <h3>
          Gunung Merbabu
        </h3>

        <p>
          Pendakian gunung dengan panorama
          sabana yang menakjubkan.
        </p>

        <br>

        <p>
          📅 20 Mei - 22 Mei 2026
        </p>

        <p>
          👥 6 Peserta
        </p>

        <p>
          📍 Jawa Tengah, Indonesia
        </p>

      </div>


      <!-- ACTION -->

      <div class="trip-history-action">

        <span class="trip-status">
          Menunggu Pembayaran
        </span>


        <div style="display:flex; gap:10px;">

          <a
            href="payment.php"
            class="btn-primary">

            Bayar
          </a>


          <a
            href="detail.php"
            class="btn-ghost">

            Lihat Detail
          </a>

        </div>

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
