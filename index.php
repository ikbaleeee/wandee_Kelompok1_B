<?php
session_start();
include 'config/database.php';

// Ambil semua destinasi dari database
$query = "SELECT * FROM destinations ORDER BY rating DESC";
$result = mysqli_query($conn, $query);
$destinations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $destinations[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wandee - Jelajahi Dunia Bersamamu</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/home.css">

  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- LUCIDE ICON -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>
  <?php include 'includes/navbar.php'; ?>



  <!-- ===================================== -->
  <!-- HERO SECTION -->
  <!-- ===================================== -->

  <section class="hero">

    <div class="hero-bg">
      <img src="assets/img/gunung.png" alt="landscape" class="hero-img" />
      <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">

      <p class="hero-eyebrow">
        Jelajahi Keindahan Dunia Bersama
        <span class="accent">Wandee</span>
      </p>

      <h2 class="hero-title">
        Temukan destinasi eksotis,<br>
        petualangan tak terlupakan,<br>
        dan momen berharga.
      </h2>

      <div class="hero-cta">

        <a href="auth/loginregister.php" class="btn-primary btn-lg">
          Mulai Eksplorasi
        </a>

        <button class="btn-ghost btn-lg">
          Lihat Promo
        </button>

      </div>


      <!-- SEARCH BAR -->

      <div class="search-bar">

        <div class="search-field search-destination">
          <i data-lucide="search"></i>
          <input type="text" placeholder="Mau pergi ke mana?" />
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


  <!-- ===================================== -->
  <!-- CATEGORIES -->
  <!-- ===================================== -->

  <section class="categories">

    <div class="container">

      <div class="cat-grid">

        <div class="cat-card" data-cat="Gunung">
          <div class="cat-icon">
            <i data-lucide="mountain"></i>
          </div>
          <span>Gunung</span>
        </div>


        <div class="cat-card" data-cat="Pantai">
          <div class="cat-icon">
            <i data-lucide="waves"></i>
          </div>
          <span>Pantai</span>
        </div>


        <div class="cat-card" data-cat="Air Terjun">
          <div class="cat-icon">
            <i data-lucide="droplets"></i>
          </div>
          <span>Air Terjun</span>
        </div>


        <div class="cat-card" data-cat="Kota">
          <div class="cat-icon">
            <i data-lucide="building-2"></i>
          </div>
          <span>Kota</span>
        </div>

      </div>

    </div>

  </section>


  <!-- ===================================== -->
  <!-- DESTINATIONS -->
  <!-- ===================================== -->

  <section class="recommended" id="destinations">

    <div class="container">

      <div class="section-header">

        <div>
          <h2 class="section-title">Rekomendasi Untukmu</h2>
          <p class="section-sub">
            Pilihan perjalanan terbaik yang siap kamu jelajahi.
          </p>
        </div>

        <a href="#destinations" class="view-all">
          Lihat Semua Destinasi
        </a>

      </div>


      <!-- DESTINATION GRID -->

      <div class="dest-grid">

        <?php if (!empty($destinations)) : ?>
          <?php foreach ($destinations as $dest) : ?>

            <a href="user/detail.php?id=<?= $dest['id'] ?>" class="dest-card" data-category="<?= htmlspecialchars($dest['category']) ?>" style="text-decoration:none;color:inherit;display:block;">

              <div class="dest-thumb">
                <img src="assets/img/<?= htmlspecialchars($dest['image']) ?>"
                     alt="<?= htmlspecialchars($dest['title']) ?>"
                     class="dest-img"
                     onerror="this.src='assets/img/gunung.png'" />

                <div class="dest-badge">★ <?= htmlspecialchars($dest['rating']) ?></div>

                <div class="dest-tags">
                  <span class="tag">Perjalanan Terbuka</span>
                </div>

              </div>

              <div class="dest-body">

                <h3 class="dest-name"><?= htmlspecialchars($dest['title']) ?></h3>

                <div class="dest-loc">
                  <i data-lucide="map-pin"></i>
                  <?= htmlspecialchars($dest['location']) ?>
                </div>

                <div class="dest-footer">

                  <div class="dest-date">
                    <?= $dest['trip_date'] ? htmlspecialchars($dest['trip_date']) : '-' ?>
                  </div>

                  <div class="dest-price">
                    <span class="per-person">Per Orang</span>
                    <span class="price"><?= htmlspecialchars($dest['price']) ?></span>
                  </div>

                </div>

              </div>

            </a>

          <?php endforeach; ?>
        <?php else : ?>
          <div class="dest-empty">Belum ada destinasi tersedia.</div>
        <?php endif; ?>

      </div>

    </div>

  </section>
  <?php include 'includes/footer.php'; ?>



  <!-- JS -->
  <script src="assets/js/script.js"></script>

  <!-- CATEGORY FILTER SCRIPT -->
  <script>
    // Filter berdasarkan kategori (cat-card)
    const catCards = document.querySelectorAll('.cat-card');
    let activeCategory = null;

    catCards.forEach((catCard) => {
      catCard.addEventListener('click', () => {
        const cat = catCard.dataset.cat;

        // Toggle: klik kategori yg sama = reset filter
        if (activeCategory === cat) {
          activeCategory = null;
          catCards.forEach(c => c.classList.remove('active'));
        } else {
          activeCategory = cat;
          catCards.forEach(c => c.classList.remove('active'));
          catCard.classList.add('active');
        }

        applyAllFilters();

        // Scroll ke section destinasi
        document.getElementById('destinations').scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Override filterDestinations dari script.js supaya juga mempertimbangkan kategori
    function applyAllFilters() {
      const query = document.querySelector('.search-destination input')?.value.trim().toLowerCase() || '';
      const searchDateInput = document.getElementById('searchDateInput');
      const selectedDate = searchDateInput?.value ? new Date(searchDateInput.value) : null;
      const destCards = document.querySelectorAll('.dest-card');
      const destGrid = document.querySelector('.dest-grid');
      let visible = 0;

      destCards.forEach((card) => {
        const name = card.querySelector('.dest-name')?.textContent.toLowerCase() || '';
        const loc = card.querySelector('.dest-loc')?.textContent.toLowerCase() || '';
        const cardCat = card.dataset.category || '';

        const hasQuery = !query || name.includes(query) || loc.includes(query);
        const hasCat = !activeCategory || cardCat === activeCategory;

        let hasDate = true;
        if (selectedDate) {
          const dateText = card.querySelector('.dest-date')?.textContent.trim();
          if (dateText && dateText !== '-') {
            const parts = dateText.split(' - ').map(p => p.trim());
            const monthMap = {
              Jan:0,Feb:1,Mar:2,Apr:3,Mei:4,Jun:5,Jul:6,Agu:7,Sep:8,Okt:9,Nov:10,Des:11
            };
            function parseDate(str) {
              const p = str.split(' ');
              if (p.length < 3) return null;
              return new Date(parseInt(p[2]), monthMap[p[1]] ?? 0, parseInt(p[0]));
            }
            const year = parts[1]?.split(' ').pop();
            const start = parseDate(parts[0] + ' ' + year);
            const end = parseDate(parts[1]);
            hasDate = start && end && selectedDate >= start && selectedDate <= end;
          } else {
            hasDate = false;
          }
        }

        if (hasQuery && hasCat && hasDate) {
          card.style.display = '';
          visible++;
        } else {
          card.style.display = 'none';
        }
      });

      // Tampilkan pesan kosong jika tidak ada hasil
      let empty = destGrid?.querySelector('.dest-empty');
      if (visible === 0) {
        if (!empty) {
          empty = document.createElement('div');
          empty.className = 'dest-empty';
          empty.textContent = 'Tidak ada destinasi sesuai filter.';
          destGrid?.appendChild(empty);
        }
      } else {
        if (empty) empty.remove();
      }
    }

    // Hubungkan search input & date ke applyAllFilters
    const searchDestInput = document.querySelector('.search-destination input');
    const searchDateInputEl = document.getElementById('searchDateInput');
    const searchBtn = document.querySelector('.btn-search');

    if (searchDestInput) searchDestInput.addEventListener('input', applyAllFilters);
    if (searchDateInputEl) searchDateInputEl.addEventListener('change', applyAllFilters);
    if (searchBtn) searchBtn.addEventListener('click', applyAllFilters);
  </script>

</body>
</html>