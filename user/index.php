<?php
session_start();

include '../config/database.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/loginregister.php");
    exit;
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dasbor Pengguna - Wandee</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../assets/css/global.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/user.css">

  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- LUCIDE -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="dashboard-page">
  <?php include '../includes/navbar.php'; ?>


  <section class="hero dashboard-hero">

    <div class="hero-bg">
      <img src="../assets/img/gunung.png" alt="Pemandangan pegunungan" class="hero-img">
      <div class="hero-overlay"></div>
    </div>

    <div class="hero-content dashboard-hero-content">

      <p class="dashboard-welcome">
        Hai, <?php echo htmlspecialchars($name); ?>
      </p>

      <p class="hero-eyebrow">
        Jelajahi Keindahan Dunia Bersama
        <span class="accent">Wandee</span>
      </p>

      <h1 class="hero-title">
        Temukan destinasi eksotis,<br>
        petualangan tak terlupakan,<br>
        dan momen berharga.
      </h1>

      <div class="hero-cta">

        <a href="#destinations" class="btn-primary btn-lg">
          Mulai Eksplorasi
        </a>

        <a href="riwayat.php" class="btn-ghost btn-lg">
          Lihat Perjalanan Saya
        </a>

      </div>

      <div class="search-bar">

        <div class="search-field search-destination">
          <i data-lucide="search"></i>
          <input type="text" placeholder="Mau pergi ke mana?">
        </div>

        <div class="search-divider"></div>

        <div class="search-field" id="searchDateField">
          <label for="searchDateInput" class="search-date-label">
            <i data-lucide="calendar-days"></i>
            <div>
              <span class="field-label">TANGGAL</span>
              <span class="field-value">Pilih Tanggal</span>
            </div>
          </label>
          <input type="date" id="searchDateInput" class="search-date-input">
        </div>

        <div class="search-divider"></div>

        <div class="search-field" id="searchParticipantField">
          <i data-lucide="users"></i>
          <div>
            <span class="field-label">PESERTA</span>
            <span class="field-value" id="searchParticipantValue">1 Dewasa</span>
          </div>
          <div class="participant-panel" id="participantPanel">
            <div class="participant-option">
              <div>
                <strong>Dewasa</strong>
                <p>Usia 13+</p>
              </div>
              <div class="participant-controls">
                <button type="button" class="participant-btn" data-type="adult" data-action="decrease">-</button>
                <span id="participantAdultCount">1</span>
                <button type="button" class="participant-btn" data-type="adult" data-action="increase">+</button>
              </div>
            </div>
            <div class="participant-option">
              <div>
                <strong>Anak</strong>
                <p>Usia 2-12</p>
              </div>
              <div class="participant-controls">
                <button type="button" class="participant-btn" data-type="child" data-action="decrease">-</button>
                <span id="participantChildCount">0</span>
                <button type="button" class="participant-btn" data-type="child" data-action="increase">+</button>
              </div>
            </div>
          </div>
        </div>

        <button class="btn-search" aria-label="Filter">
          <i data-lucide="sliders-horizontal"></i>
        </button>

      </div>

    </div>

  </section>


  <section class="categories">

    <div class="container">

      <div class="cat-grid">

        <a href="#destinations" class="cat-card" data-cat="Gunung">
          <div class="cat-icon">
            <i data-lucide="mountain"></i>
          </div>
          <span>Gunung</span>
        </a>

        <a href="#destinations" class="cat-card" data-cat="Pantai">
          <div class="cat-icon">
            <i data-lucide="waves"></i>
          </div>
          <span>Pantai</span>
        </a>

        <a href="#destinations" class="cat-card" data-cat="Air Terjun">
          <div class="cat-icon">
            <i data-lucide="droplets"></i>
          </div>
          <span>Air Terjun</span>
        </a>

        <a href="#destinations" class="cat-card" data-cat="Kota">
          <div class="cat-icon">
            <i data-lucide="building-2"></i>
          </div>
          <span>Kota</span>
        </a>

      </div>

    </div>

  </section>

  <section class="recommended" id="destinations">

    <div class="container">

      <div class="section-header">

        <div>
          <h2 class="section-title">Rekomendasi Untukmu</h2>
          <p class="section-sub">
            Pilihan trip terbaik yang siap menemani perjalananmu.
          </p>
        </div>

        <a href="favorite.php" class="view-all">
          Lihat Favorit
        </a>

      </div>

      <div class="dest-grid">

        <a href="detail.php" class="dest-card">
          <div class="dest-thumb">
            <img src="../assets/img/bromo.png" alt="Bromo dan Malang" class="dest-img">
            <div class="dest-badge">5.0</div>
            <div class="dest-tags">
              <span class="tag">Perjalanan Terbuka</span>
            </div>
          </div>

          <div class="dest-body">
            <h3 class="dest-name">Bromo & Malang</h3>
            <div class="dest-loc">
              <i data-lucide="map-pin"></i>
              Jawa Timur, Indonesia
            </div>
            <div class="dest-footer">
              <div class="dest-date">01 Mei - 03 Mei 2026</div>
              <div class="dest-price">
                <span class="per-person">Per Orang</span>
                <span class="price">Rp 3jt</span>
              </div>
            </div>
          </div>
        </a>

        <a href="detail.php" class="dest-card">
          <div class="dest-thumb">
            <img src="../assets/img/rajaampat.png" alt="Raja Ampat" class="dest-img">
            <div class="dest-badge">5.0</div>
            <div class="dest-tags">
              <span class="tag">Perjalanan Terbuka</span>
            </div>
          </div>

          <div class="dest-body">
            <h3 class="dest-name">Raja Ampat</h3>
            <div class="dest-loc">
              <i data-lucide="map-pin"></i>
              Papua Barat, Indonesia
            </div>
            <div class="dest-footer">
              <div class="dest-date">10 Mei - 15 Mei 2026</div>
              <div class="dest-price">
                <span class="per-person">Per Orang</span>
                <span class="price">Rp 8jt</span>
              </div>
            </div>
          </div>
        </a>

        <a href="detail.php" class="dest-card">
          <div class="dest-thumb">
            <img src="../assets/img/merbabu.png" alt="Merbabu" class="dest-img">
            <div class="dest-badge">4.9</div>
            <div class="dest-tags">
              <span class="tag">Perjalanan Terbuka</span>
            </div>
          </div>

          <div class="dest-body">
            <h3 class="dest-name">Merbabu</h3>
            <div class="dest-loc">
              <i data-lucide="map-pin"></i>
              Jawa Tengah, Indonesia
            </div>
            <div class="dest-footer">
              <div class="dest-date">20 Mei - 22 Mei 2026</div>
              <div class="dest-price">
                <span class="per-person">Per Orang</span>
                <span class="price">Rp 2.5jt</span>
              </div>
            </div>
          </div>
        </a>

      </div>

    </div>

  </section>
  <?php include '../includes/footer.php'; ?>

  <!-- JS -->
  <script src="../assets/js/script.js"></script>

</body>
</html>
