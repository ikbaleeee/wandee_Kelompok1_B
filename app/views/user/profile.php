<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Profil - Wandee</title>

  <!-- CSS -->
  <link rel="stylesheet" href="/wandee/public/assets/css/styles.css">

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
  <?php require __DIR__ . '/../partials/navbar.php'; ?>




  <!-- ===================================== -->
  <!-- PROFILE -->
  <!-- ===================================== -->

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
            src="/wandee/public/uploads/profile/<?php echo htmlspecialchars($user['photo']); ?>"
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
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
          </div>

          <span class="profile-role">
            <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
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

          <a href="/wandee/user/favorite">
            Favorit
          </a>

          <a href="/wandee/user/riwayat">
            Riwayat Perjalanan
          </a>

          <a href="/wandee/user/ulasan">
            Ulasan
          </a>

          <a href="/wandee/auth/logout" data-logout-link>
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
            <strong><?php echo htmlspecialchars($user['name']); ?></strong>
            </div>

            <div class="profile-info-item">
              <span>Email</span>
              <strong><?php echo htmlspecialchars($user['email']); ?></strong>
            </div>

            <div class="profile-info-item">
              <span>Peran</span>
              <strong><?php echo htmlspecialchars(ucfirst($user['role'])); ?></strong>
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
            action="/wandee/user/update_profile"
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
                value="<?php echo htmlspecialchars($user['name']); ?>"
                required>
            </div>

            <div class="profile-field">
              <label>Email</label>
              <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($user['email']); ?>"
                required>
            </div>

            <div class="profile-field full-span file-upload-wrap">
              <label>Foto Profil</label>
              <label class="file-upload-box" for="profilePhotoInput">
                <span class="file-upload-button">Choose File</span>
                <span class="file-upload-name" id="profilePhotoName">No file chosen</span>
              </label>
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

      </div>

    </div>

  </section>
  <?php require __DIR__ . '/../partials/logout_modal.php'; ?>
  <?php require __DIR__ . '/../partials/footer.php'; ?>

  <!-- JS -->

  <script src="/wandee/public/assets/js/script.js"></script>

  <script>
    const profilePhotoInput = document.getElementById('profilePhotoInput');
    const profilePhotoName = document.getElementById('profilePhotoName');

    if (profilePhotoInput && profilePhotoName) {
      profilePhotoInput.addEventListener('change', () => {
        profilePhotoName.textContent = profilePhotoInput.files[0]?.name || 'No file chosen';
      });
    }

    lucide.createIcons();
  </script>

</body>
</html>
