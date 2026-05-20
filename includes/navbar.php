<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$currentPath = $_SERVER['PHP_SELF'] ?? '';

function nav_active($needle, $currentPath){
    return strpos($currentPath, $needle) !== false ? ' class="active"' : '';
}

?>

<nav class="navbar">

  <a href="/wandee/index.php" class="nav-logo">Wandee</a>

  <ul class="nav-links">

    <li>
      <a href="/wandee/index.php"<?php echo basename($currentPath) === 'index.php' && strpos($currentPath, '/user/') === false ? ' class="active"' : ''; ?>>
        Jelajah
      </a>
    </li>

    <li>
      <a href="/wandee/index.php#destinations">
        Destinasi
      </a>
    </li>

    <li>
      <a href="/wandee/user/ulasan.php"<?php echo nav_active('/user/ulasan.php', $currentPath); ?>>
        Ulasan
      </a>
    </li>

    <li>
      <a href="/wandee/user/riwayat.php"<?php echo nav_active('/user/riwayat.php', $currentPath); ?>>
        Perjalanan Saya
      </a>
    </li>

    <li>
      <a href="/wandee/user/favorite.php"<?php echo nav_active('/user/favorite.php', $currentPath); ?>>
        Favorit
      </a>
    </li>

  </ul>

  <div class="nav-actions">

    <a href="/wandee/user/notifikasi.php" class="btn-icon notification-toggle" aria-label="Notifikasi">
      <i data-lucide="bell"></i>
      <span class="notification-dot">3</span>
    </a>

    <?php if(isset($_SESSION['user_id'])) : ?>

      <a href="/wandee/user/profile.php" class="btn-icon" aria-label="Profil">
        <i data-lucide="user"></i>
      </a>

      <a href="/wandee/index.php#destinations" class="btn-primary">
        Pesan Sekarang
      </a>

    <?php else : ?>

      <a href="/wandee/auth/loginregister.php" class="btn-icon" aria-label="Profil">
        <i data-lucide="user"></i>
      </a>

      <a href="/wandee/auth/loginregister.php" class="btn-primary">
        Pesan Sekarang
      </a>

    <?php endif; ?>

  </div>

</nav>
