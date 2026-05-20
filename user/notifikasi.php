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

  <title>Notifikasi - Wandee</title>

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

<body class="notification-page">

  <?php include '../includes/navbar.php'; ?>

  <main class="notification-page-wrap">

    <section class="notification-page-hero">

      <span class="favorite-kicker">
        <i data-lucide="bell"></i>
        Pusat Notifikasi
      </span>

      <div class="notification-page-title">
        <div>
          <h1>Notifikasi</h1>
          <p>
            Pantau semua kabar terbaru tentang pembayaran, perjalanan, dan aktivitas akunmu.
          </p>
        </div>

        <button class="btn-ghost notification-mark-read" type="button">
          Tandai Semua Dibaca
        </button>
      </div>

    </section>

    <section class="notification-page-layout">

      <div class="notification-feed">

        <a href="payment.php" class="notification-card unread">
          <span class="notification-card-icon">
            <i data-lucide="credit-card"></i>
          </span>

          <div class="notification-card-body">
            <div class="notification-card-head">
              <h2>Pembayaran menunggu</h2>
              <small>5 menit lalu</small>
            </div>

            <p>
              Selesaikan pembayaran perjalanan Bromo & Malang sebelum batas waktu berakhir.
            </p>

            <span class="notification-status">Perlu tindakan</span>
          </div>
        </a>

        <a href="riwayat.php" class="notification-card unread">
          <span class="notification-card-icon">
            <i data-lucide="calendar-check"></i>
          </span>

          <div class="notification-card-body">
            <div class="notification-card-head">
              <h2>Perjalanan dikonfirmasi</h2>
              <small>1 jam lalu</small>
            </div>

            <p>
              Slot perjalanan kamu sudah berhasil diamankan. Cek detail perjalanan di halaman riwayat.
            </p>

            <span class="notification-status">Baru</span>
          </div>
        </a>

        <a href="ulasan.php" class="notification-card unread">
          <span class="notification-card-icon">
            <i data-lucide="star"></i>
          </span>

          <div class="notification-card-body">
            <div class="notification-card-head">
              <h2>Bagikan ulasan</h2>
              <small>Kemarin</small>
            </div>

            <p>
              Ceritakan pengalamanmu setelah mengikuti perjalanan agar penjelajah lain terbantu.
            </p>

            <span class="notification-status">Menunggu ulasan</span>
          </div>
        </a>

        <a href="favorite.php" class="notification-card">
          <span class="notification-card-icon">
            <i data-lucide="heart"></i>
          </span>

          <div class="notification-card-body">
            <div class="notification-card-head">
              <h2>Destinasi favorit tersimpan</h2>
              <small>2 hari lalu</small>
            </div>

            <p>
              Raja Ampat berhasil ditambahkan ke daftar favoritmu.
            </p>

            <span class="notification-status muted">Dibaca</span>
          </div>
        </a>

      </div>

    </section>

  </main>

  <?php include '../includes/footer.php'; ?>

  <!-- JS -->

  <script src="../assets/js/script.js"></script>

</body>
</html>
