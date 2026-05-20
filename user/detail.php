<?php

session_start();

include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/loginregister.php");
    exit;
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: ../index.php#destinations");
    exit;
}

// Query destinasi berdasarkan ID
$stmt = mysqli_prepare($conn, "SELECT * FROM destinations WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$dest = mysqli_fetch_assoc($result);

if (!$dest) {
    header("Location: ../index.php#destinations");
    exit;
}

// Buat itinerary & fasilitas otomatis berdasarkan kategori
$category = $dest['category'];
$title    = $dest['title'];
$days     = 1;

// Hitung jumlah hari dari trip_date (misal "01 Mei - 03 Mei 2026")
if (!empty($dest['trip_date'])) {
    preg_match('/(\d+)\s+\w+\s*-\s*(\d+)/', $dest['trip_date'], $m);
    if (!empty($m[1]) && !empty($m[2])) {
        $days = abs((int)$m[2] - (int)$m[1]) + 1;
        if ($days < 1) $days = 1;
    }
}

// Template itinerary per kategori
$itineraries = [];
$facilities  = [];

if ($category === 'Gunung') {
    $itineraries = [
        ['label' => 'Hari ke-1', 'title' => 'Perjalanan & Aklimatisasi', 'desc' => 'Tiba di basecamp, registrasi, briefing pendakian, istirahat dan persiapan perlengkapan.', 'time' => '10.00 - 18.00 WIB'],
        ['label' => 'Hari ke-2', 'title' => 'Summit Attack & Sunrise', 'desc' => 'Dini hari mendaki ke puncak untuk menikmati sunrise terbaik dan panorama alam yang menakjubkan.', 'time' => '02.00 - 14.00 WIB'],
    ];
    if ($days >= 3) {
        $itineraries[] = ['label' => 'Hari ke-3', 'title' => 'Turun & Kembali', 'desc' => 'Turun gunung, pembersihan peralatan, oleh-oleh, dan perjalanan pulang ke kota.', 'time' => '07.00 - 18.00 WIB'];
    }
    $facilities = ['Transportasi', 'Tenda & Matras', 'Porter', 'Makan', 'P3K'];

} elseif ($category === 'Pantai') {
    $itineraries = [
        ['label' => 'Hari ke-1', 'title' => 'Tiba & Explore Pantai', 'desc' => 'Tiba di lokasi, check-in penginapan, eksplorasi pantai, snorkeling dan menikmati senja.', 'time' => '10.00 - 18.00 WIB'],
        ['label' => 'Hari ke-2', 'title' => 'Island Hopping & Diving', 'desc' => 'Keliling pulau-pulau sekitar, diving, menikmati keindahan bawah laut dan kuliner lokal.', 'time' => '07.00 - 17.00 WIB'],
    ];
    if ($days >= 3) {
        $itineraries[] = ['label' => 'Hari ke-3', 'title' => 'Sunrise & Kepulangan', 'desc' => 'Menikmati sunrise di pantai, sarapan khas lokal, belanja oleh-oleh, dan perjalanan pulang.', 'time' => '05.00 - 15.00 WIB'];
    }
    $facilities = ['Transportasi', 'Penginapan', 'Snorkeling Gear', 'Makan', 'Pemandu Lokal'];

} elseif ($category === 'Air Terjun') {
    $itineraries = [
        ['label' => 'Hari ke-1', 'title' => 'Tiba & Trekking Awal', 'desc' => 'Tiba di lokasi, trekking ringan menuju basecamp, menikmati suasana alam sekitar.', 'time' => '09.00 - 17.00 WIB'],
        ['label' => 'Hari ke-2', 'title' => 'Kunjungi Air Terjun Utama', 'desc' => 'Trekking ke air terjun utama, mandi di kolam alami, foto-foto, dan menikmati udara segar pegunungan.', 'time' => '07.00 - 16.00 WIB'],
    ];
    if ($days >= 3) {
        $itineraries[] = ['label' => 'Hari ke-3', 'title' => 'Air Terjun Tersembunyi & Pulang', 'desc' => 'Menjelajahi air terjun tersembunyi di sekitar lokasi, piknik, oleh-oleh, dan kembali ke kota.', 'time' => '08.00 - 18.00 WIB'];
    }
    $facilities = ['Transportasi', 'Pemandu', 'Makan Siang', 'Tiket Masuk', 'Dokumentasi'];

} elseif ($category === 'Kota') {
    $itineraries = [
        ['label' => 'Hari ke-1', 'title' => 'City Tour & Kuliner', 'desc' => 'Kunjungi landmark ikonik kota, wisata kuliner lokal, museum, dan pusat perbelanjaan.', 'time' => '09.00 - 20.00 WIB'],
        ['label' => 'Hari ke-2', 'title' => 'Wisata Budaya & Belanja', 'desc' => 'Mengunjungi situs budaya dan bersejarah, belanja oleh-oleh khas, dan hiburan malam kota.', 'time' => '10.00 - 21.00 WIB'],
    ];
    if ($days >= 3) {
        $itineraries[] = ['label' => 'Hari ke-3', 'title' => 'Wisata Alam Pinggir Kota & Pulang', 'desc' => 'Kunjungi destinasi alam di sekitar kota, sarapan khas, dan perjalanan pulang.', 'time' => '08.00 - 17.00 WIB'];
    }
    $facilities = ['Transportasi', 'Penginapan', 'Tiket Wisata', 'Makan', 'Pemandu'];

} else {
    $itineraries = [
        ['label' => 'Hari ke-1', 'title' => 'Tiba & Eksplorasi', 'desc' => 'Tiba di lokasi, orientasi, eksplorasi area sekitar dan menikmati suasana setempat.', 'time' => '09.00 - 17.00 WIB'],
    ];
    $facilities = ['Transportasi', 'Pemandu', 'Makan', 'Dokumentasi'];
}

// Ikon fasilitas
$facility_icons = [
    'Transportasi'    => 'bus',
    'Penginapan'      => 'hotel',
    'Tiket Masuk'     => 'ticket',
    'Tiket Wisata'    => 'ticket',
    'Makan'           => 'utensils',
    'Makan Siang'     => 'utensils',
    'Dokumentasi'     => 'camera',
    'Pemandu'         => 'user-check',
    'Pemandu Lokal'   => 'user-check',
    'Porter'          => 'backpack',
    'P3K'             => 'heart-pulse',
    'Snorkeling Gear' => 'waves',
    'Tenda & Matras'  => 'tent',
    'Asuransi'        => 'shield-check',
];

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($dest['title']) ?> - Wandee</title>

  <link rel="stylesheet" href="../assets/css/global.css">
  <link rel="stylesheet" href="../assets/css/detail.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="detail-page">
  <?php include '../includes/navbar.php'; ?>

  <main class="detail-shell">

    <a href="../index.php#destinations" class="detail-back">
      <i data-lucide="arrow-left"></i>
      Kembali ke Jelajah
    </a>

    <section class="detail-grid-new">

      <!-- KIRI -->
      <div class="detail-left-new">

        <!-- Kartu Gambar & Info -->
        <article class="detail-destination-card">

          <div class="detail-image-wrap">
            <img
              src="../assets/img/<?= htmlspecialchars($dest['image']) ?>"
              alt="<?= htmlspecialchars($dest['title']) ?>"
              onerror="this.src='../assets/img/gunung.png'">

            <span class="detail-open-badge">Perjalanan Terbuka</span>
            <span class="detail-rating-badge">★ <?= htmlspecialchars($dest['rating']) ?></span>
          </div>

          <div class="detail-destination-body">

            <h1><?= htmlspecialchars($dest['title']) ?></h1>

            <p class="detail-rating-line">
              <strong><?= htmlspecialchars($dest['rating']) ?></strong>
              <span>Open Trip</span>
              <span><?= htmlspecialchars($dest['category']) ?></span>
            </p>

            <div class="detail-info-strip-new">

              <div>
                <i data-lucide="map-pin"></i>
                <span>Lokasi</span>
                <strong><?= htmlspecialchars($dest['location']) ?></strong>
              </div>

              <div>
                <i data-lucide="calendar-days"></i>
                <span>Tanggal</span>
                <strong><?= $dest['trip_date'] ? htmlspecialchars($dest['trip_date']) : '-' ?></strong>
              </div>

              <div>
                <i data-lucide="tag"></i>
                <span>Kategori</span>
                <strong><?= htmlspecialchars($dest['category']) ?></strong>
              </div>

            </div>

          </div>

        </article>

        <!-- Harga -->
        <section class="detail-price-card">
          <span>Harga Per Orang</span>
          <h2><?= htmlspecialchars($dest['price']) ?><small>/orang</small></h2>
          <p>Slot tersedia</p>
        </section>

        <!-- Tentang -->
        <section class="detail-about-card">
          <h2>Tentang Perjalanan</h2>
          <p><?= nl2br(htmlspecialchars($dest['description'] ?? 'Deskripsi belum tersedia.')) ?></p>
        </section>

      </div>

      <!-- KANAN  -->
      <div class="detail-right-new">

        <!-- Itinerary -->
        <section class="detail-panel detail-itinerary-panel">

          <h2>
            <i data-lucide="map"></i>
            Rencana Perjalanan
          </h2>

          <div class="detail-timeline">
            <?php foreach ($itineraries as $item) : ?>
              <article>
                <span><?= htmlspecialchars($item['label']) ?></span>
                <h3><?= htmlspecialchars($item['title']) ?></h3>
                <p><?= htmlspecialchars($item['desc']) ?></p>
                <small>
                  <i data-lucide="clock-3"></i>
                  <?= htmlspecialchars($item['time']) ?>
                </small>
              </article>
            <?php endforeach; ?>
          </div>

        </section>

        <!-- Fasilitas -->
        <section class="detail-panel">
          <h2>Fasilitas</h2>
          <div class="detail-facilities">
            <?php foreach ($facilities as $fac) : ?>
              <?php $icon = $facility_icons[$fac] ?? 'check-circle'; ?>
              <span>
                <i data-lucide="<?= $icon ?>"></i>
                <?= htmlspecialchars($fac) ?>
              </span>
            <?php endforeach; ?>
          </div>
        </section>

        <!-- Join -->
        <section class="detail-join-card">
          <div>
            <span>Total Harga</span>
            <strong><?= htmlspecialchars($dest['price']) ?></strong>
            <small>/orang</small>
          </div>
          <a href="payment.php" class="btn-primary">Ikut Perjalanan</a>
        </section>

      </div>

    </section>

  </main>

  <?php include '../includes/footer.php'; ?>

  <script src="../assets/js/script.js"></script>

</body>
</html>
