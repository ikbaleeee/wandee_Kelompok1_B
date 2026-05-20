<?php

session_start();

include '../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/loginregister.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($query);

$favorites_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM favorites WHERE user_id='$user_id'"));
$bookings_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM bookings WHERE user_id='$user_id'"));
$reviews_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM reviews WHERE user_id='$user_id'"));

?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Profil - Wandee</title>

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

<body class="profile-page">
  <?php include '../includes/navbar.php'; ?>



  <!-- PROFILE -->

  <section class="profile-wrap">


    <!-- HERO -->

    <div class="profile-hero">

      <span class="favorite-kicker">

        <i data-lucide="sparkles"></i>

        Profil Pengguna

      </span>


      <h1>
        Profil Saya
      </h1>

      <p>
        Kelola informasi akun dan personalisasi
        profile Wandee kamu di sini.
      </p>

    </div>



    <!-- PROFILE HEADER -->

    <div class="profile-avatar-wrap">

      <div class="profile-avatar">

        <?php if(!empty($user['photo'])) : ?>

          <img
            src="../assets/uploads/profile/<?php echo $user['photo']; ?>"
            alt="Profil">

        <?php else : ?>

          <div class="profile-avatar-empty">
            <i data-lucide="user"></i>
          </div>

        <?php endif; ?>

        <button
          type="button"
          class="profile-avatar-edit"
          onclick="document.getElementById('profilePhotoInput').click()"
          aria-label="Ubah foto profil">
          <i data-lucide="edit-2"></i>
        </button>

      </div>


      <div class="profile-heading">

        <div class="profile-heading-top">

          <div>
            <h2><?php echo $user['name']; ?></h2>
            <p><?php echo $user['email']; ?></p>
          </div>

          <span class="profile-role">
            <?php echo ucfirst($user['role']); ?>
          </span>

        </div>

        <div class="profile-badges">
          <span>Wandee Member</span>
          <span>Bergabung sejak <?php echo date('d F Y', strtotime($user['created_at'])); ?></span>
        </div>

        <div class="profile-summary-cards">

          <div class="profile-summary-card">
            <strong><?php echo $favorites_count; ?></strong>
            <span>Favorit</span>
          </div>

          <div class="profile-summary-card">
            <strong><?php echo $bookings_count; ?></strong>
            <span>Perjalanan</span>
          </div>

          <div class="profile-summary-card">
            <strong><?php echo $reviews_count; ?></strong>
            <span>Ulasan</span>
          </div>

        </div>

      </div>

    </div>



    <!-- PROFILE LAYOUT -->

    <div class="profile-layout">


      <!-- SIDEBAR -->

      <aside class="profile-sidebar">

        <div class="profile-menu">

          <a href="#" class="active">
            Informasi Akun
          </a>

          <a href="favorite.php">
            Favorit
          </a>

          <a href="riwayat.php">
            Riwayat Perjalanan
          </a>

          <a href="ulasan.php">
            Ulasan
          </a>

          <a href="../process/logout.php">
            Keluar
          </a>

        </div>

      </aside>



      <!-- CONTENT -->

      <div class="profile-content">

        <div class="profile-panel profile-details-panel">

          <div class="profile-panel-title">
            <h3>Informasi Profil</h3>
            <p>Lihat semua detail akun dan status profil.</p>
          </div>

          <div class="profile-info-grid">

            <div class="profile-info-item">
              <span>Nama Lengkap</span>
              <strong><?php echo $user['name']; ?></strong>
            </div>

            <div class="profile-info-item">
              <span>Email</span>
              <strong><?php echo $user['email']; ?></strong>
            </div>

            <div class="profile-info-item">
              <span>Peran</span>
              <strong><?php echo ucfirst($user['role']); ?></strong>
            </div>

            <div class="profile-info-item">
              <span>Bergabung Sejak</span>
              <strong><?php echo date('d F Y', strtotime($user['created_at'])); ?></strong>
            </div>

          </div>

        </div>

        <div class="profile-panel">

          <div class="profile-panel-title">
            <h3>Edit Profil</h3>
            <p>Perbarui informasi akun kamu, termasuk foto profil.</p>
          </div>

          <form
            class="profile-form"
            action="../process/user_process.php"
            method="POST"
            enctype="multipart/form-data">

            <input
              type="hidden"
              name="action"
              value="update_profile">

            <div class="profile-field">
              <label>Nama Lengkap</label>
              <input
                type="text"
                name="name"
                value="<?php echo $user['name']; ?>"
                required>
            </div>

            <div class="profile-field">
              <label>Email</label>
              <input
                type="email"
                name="email"
                value="<?php echo $user['email']; ?>"
                required>
            </div>

            <div class="profile-field full-span file-upload-wrap">
              <label>Foto Profil</label>
              <div class="file-upload-control">
                <button
                  type="button"
                  class="file-upload-button"
                  onclick="document.getElementById('profilePhotoInput').click()">
                  Pilih Foto
                </button>
                <span class="file-upload-filename">Tidak ada file dipilih</span>
              </div>
              <input
                type="file"
                name="photo"
                id="profilePhotoInput"
                class="file-upload-input">
            </div>

            <div class="profile-field full-span">
              <label>Password Baru</label>
              <input
                type="password"
                name="password"
                placeholder="Kosongkan jika tidak ingin mengganti">
            </div>

            <div class="profile-save">
              <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>

          </form>

        </div>

        <div class="profile-panel">

          <div class="profile-panel-title">
            <h3>Keamanan Akun</h3>
            <p>Kelola password dan tingkat keamanan akun dengan cepat.</p>
          </div>

          <div class="security-grid">

            <div class="security-card">
              <div class="security-card-top">
                <div>
                  <strong>Ubah Kata Sandi</strong>
                  <p>Perbarui password untuk menjaga keamanan akunmu.</p>
                </div>
                <button type="button" class="btn-secondary">Perbarui Sandi</button>
              </div>
              <p class="security-note">Terakhir diubah 3 bulan yang lalu</p>
            </div>

            <div class="security-card">
              <div class="security-card-top">
                <div>
                  <strong>Autentikasi Dua Faktor</strong>
                  <p>Tambahkan lapisan keamanan ekstra untuk akun kamu.</p>
                </div>
                <span class="security-pill">NONAKTIF</span>
              </div>
              <div class="security-toggle">
                <label class="toggle-switch">
                  <input type="checkbox" disabled>
                  <span></span>
                </label>
                <span class="security-toggle-label">Fitur akan tersedia segera</span>
              </div>
            </div>

          </div>

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
