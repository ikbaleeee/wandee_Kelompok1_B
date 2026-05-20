<?php

session_start();

include '../config/database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../auth/loginregister.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$user_query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($user_query);

$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$total_trips = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM trips"));
$total_bookings = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM bookings"));
$total_payments = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM payments"));

?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
  >

  <title>Dashboard Admin - Wandee</title>

  <link
    rel="stylesheet"
    href="../assets/css/global.css"
  >

  <link
    rel="stylesheet"
    href="../assets/css/admin.css"
  >

  <link
    rel="preconnect"
    href="https://fonts.googleapis.com"
  >

  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
  >

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  >

  <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="admin-page">

<div class="admin-wrap">

  <!-- SIDEBAR -->

  <aside class="admin-sidebar">

    <div class="admin-logo">
      Wandee Admin
    </div>

    <nav class="admin-menu">

      <a href="dashboard.php" class="active">
        <i data-lucide="layout-dashboard"></i>
        Dashboard
      </a>

      <a href="manage.php">
        <i data-lucide="map"></i>
        Manage Destinasi
      </a>

      <a href="profile.php">
        <i data-lucide="user"></i>
        Profil Saya
      </a>

      <a href="../process/logout.php">
        <i data-lucide="log-out"></i>
        Keluar
      </a>

    </nav>

  </aside>


  <!-- MAIN -->

  <main class="admin-main">

    <!-- HERO -->

    <div class="admin-header-small">

      <div>

        <span class="admin-badge">
          Dashboard Admin
        </span>

        <h1>
          Selamat datang,
          <?php echo $user['name']; ?>!
        </h1>

        <p>
          Kelola destinasi wisata, pengguna,
          transaksi perjalanan, dan seluruh
          aktivitas Wandee dari dashboard admin.
        </p>

      </div>

      <div class="admin-user">

        <?php if(!empty($user['photo'])) : ?>

          <img
            src="../assets/uploads/profile/<?php echo $user['photo']; ?>"
            alt="Admin"
          >

        <?php else : ?>

          <div class="admin-user-empty">
            <i data-lucide="user"></i>
          </div>

        <?php endif; ?>

        <div>

          <strong>
            <?php echo $user['name']; ?>
          </strong>

          <p>
            <?php echo $user['email']; ?>
          </p>

        </div>

      </div>

    </div>


    <!-- STATS -->

    <div class="admin-stats">

      <div class="stat-card">

        <p>Pengguna Terdaftar</p>

        <h2>
          <?php echo $total_users; ?>
        </h2>

        <span class="stat-growth">
          <i data-lucide="users"></i>
          Semua akun
        </span>

      </div>

      <div class="stat-card">

        <p>Perjalanan</p>

        <h2>
          <?php echo $total_trips; ?>
        </h2>

        <span class="stat-growth">
          <i data-lucide="map-pin"></i>
          Paket aktif
        </span>

      </div>

      <div class="stat-card">

        <p>Pemesanan</p>

        <h2>
          <?php echo $total_bookings; ?>
        </h2>

        <span class="stat-growth">
          <i data-lucide="briefcase"></i>
          Transaksi
        </span>

      </div>

      <div class="stat-card">

        <p>Pembayaran</p>

        <h2>
          <?php echo $total_payments; ?>
        </h2>

        <span class="stat-growth">
          <i data-lucide="credit-card"></i>
          Bukti masuk
        </span>

      </div>

    </div>

  </main>

</div>

<script>
  lucide.createIcons();
</script>

</body>
</html>
