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

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Admin - Wandee</title>
  <link rel="stylesheet" href="../assets/css/global.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="admin-page">
  <div class="admin-wrap">

    <aside class="admin-sidebar">
      <div class="admin-logo">Wandee Admin</div>
      <nav class="admin-menu">
        <a href="dashboard.php"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a href="profile.php" class="active"><i data-lucide="user"></i> Profil Saya</a>
        <a href="../process/logout.php"><i data-lucide="log-out"></i> Keluar</a>
      </nav>
    </aside>

    <main class="admin-main">
      <div class="admin-topbar">
        <div class="admin-title">
          <h1>Profil Admin</h1>
          <p>Atur detail akun admin dan perbarui informasi profil.</p>
        </div>

        <div class="admin-user">
          <?php if(!empty($user['photo'])) : ?>
            <img src="../assets/uploads/profile/<?php echo $user['photo']; ?>" alt="Admin">
          <?php else : ?>
            <div class="admin-user-empty">
              <i data-lucide="user"></i>
            </div>
          <?php endif; ?>
          <div>
            <strong><?php echo $user['name']; ?></strong>
            <p><?php echo $user['email']; ?></p>
          </div>
        </div>
      </div>

      <section class="admin-section">
        <div class="admin-section-head">
          <h3>Detail Profil</h3>
          <p>Gunakan halaman ini untuk melihat dan mengubah profil admin.</p>
        </div>

        <div class="profile-info-grid" style="margin-bottom: 24px;">
          <div class="profile-info-item">
            <span>Nama Lengkap</span>
            <strong><?php echo $user['name']; ?></strong>
          </div>
          <div class="profile-info-item">
            <span>Email</span>
            <strong><?php echo $user['email']; ?></strong>
          </div>
          <div class="profile-info-item">
            <span>Role</span>
            <strong><?php echo ucfirst($user['role']); ?></strong>
          </div>
          <div class="profile-info-item">
            <span>Bergabung Sejak</span>
            <strong><?php echo date('d F Y', strtotime($user['created_at'])); ?></strong>
          </div>
        </div>

        <div class="admin-section">
          <div class="admin-section-head">
            <h3>Perbarui Profil</h3>
            <p>Edit nama, email, password, dan foto profil admin.</p>
          </div>

          <form action="../process/user_process.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 20px;">
            <input type="hidden" name="action" value="update_profile">

            <div style="display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 20px;">
              <div class="profile-field">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
              </div>
              <div class="profile-field">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
              </div>
            </div>

            <div class="profile-field full-span">
              <label>Foto Profil</label>
              <input type="file" name="photo">
            </div>

            <div class="profile-field full-span">
              <label>Password Baru</label>
              <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti">
            </div>

            <div class="profile-save">
              <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
