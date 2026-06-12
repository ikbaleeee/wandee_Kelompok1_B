<?php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($dest['title'] ?? '') ?> - Wandee</title>
  <link rel="stylesheet" href="/wandee/public/assets/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="detail-page">
  <?php require __DIR__ . '/../partials/navbar.php'; ?>

  <main class="detail-shell">

    <a href="/wandee/#destinations" class="detail-back">
      <i data-lucide="arrow-left"></i>
      Kembali ke Jelajah
    </a>

    <?php if (isset($_SESSION['booking_error'])): ?>
      <div class="booking-error-alert" style="background: rgba(255, 79, 129, 0.15); border: 1px solid rgba(255, 79, 129, 0.3); color: #ff4f81; padding: 18px 24px; border-radius: 20px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 12px; max-width: 1240px; margin-left: auto; margin-right: auto;">
        <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
        <span><?= htmlspecialchars($_SESSION['booking_error']) ?></span>
      </div>
      <?php unset($_SESSION['booking_error']); ?>
    <?php endif; ?>

    <section class="detail-grid-new">

      <!-- KIRI -->
      <div class="detail-left-new">

        <article class="detail-destination-card">

          <div class="detail-image-wrap">

            <form action="/wandee/user/favorite_toggle" method="POST" class="favorite-overlay-form">
              <input type="hidden" name="destination_id" value="<?= (int)$dest['id'] ?>">
              <input type="hidden" name="return_to" value="/user/detail?id=<?= (int)$dest['id'] ?>">
              <button type="submit" class="favorite-overlay-btn <?= $isFavorite ? 'active' : '' ?>">♥</button>
            </form>

            <img
              src="/wandee/public/assets/img/<?= htmlspecialchars($dest['image'] ?? '') ?>"
              alt="<?= htmlspecialchars($dest['title'] ?? '') ?>"
              onerror="this.src='/wandee/public/assets/img/gunung.png'">

            <?php if ((int)($dest['quota'] ?? 0) > 0): ?>
              <span class="detail-open-badge">Perjalanan Terbuka</span>
            <?php else: ?>
              <span class="detail-open-badge detail-full-badge" style="background: rgba(255, 79, 129, 0.15); color: #ff4f81; border: 1px solid rgba(255, 79, 129, 0.3);">Kuota Penuh</span>
            <?php endif; ?>
            <span class="detail-rating-badge">★ <?= htmlspecialchars($dest['rating'] ?? '') ?></span>
          </div>

          <div class="detail-destination-body">

            <h1><?= htmlspecialchars($dest['title'] ?? '') ?></h1>

            <p class="detail-rating-line">
              <strong><?= htmlspecialchars($dest['rating'] ?? '') ?></strong>
              <span>Open Trip</span>
              <span><?= htmlspecialchars($dest['category'] ?? '') ?></span>
            </p>

            <div class="detail-info-strip-new">
              <div>
                <i data-lucide="map-pin"></i>
                <span>Lokasi</span>
                <strong><?= htmlspecialchars($dest['location'] ?? '') ?></strong>
              </div>
              <div>
                <i data-lucide="calendar-days"></i>
                <span>Tanggal</span>
                <strong><?= $dest['trip_date'] ? htmlspecialchars($dest['trip_date']) : '-' ?></strong>
              </div>
              <div>
                <i data-lucide="tag"></i>
                <span>Kategori</span>
                <strong><?= htmlspecialchars($dest['category'] ?? '') ?></strong>
              </div>
            </div>

          </div>

        </article>

        <!-- Harga -->
        <section class="detail-price-card">
          <span>Harga Per Orang</span>
          <h2>Rp <?= number_format((int)($dest['price'] ?? 0), 0, ',', '.') ?><small>/orang</small></h2>
          <p><?= (int)($dest['quota'] ?? 0) ?> slot tersedia</p>
        </section>

        <!-- Tentang -->
        <section class="detail-about-card">
          <h2>Tentang Perjalanan</h2>
          <p><?= nl2br(htmlspecialchars($dest['description'] ?? 'Deskripsi belum tersedia.')) ?></p>
        </section>

        <section class="detail-panel detail-reviews-card detail-reviews-summary">
          <div>
            <h2>
              <i data-lucide="message-square"></i>
              Ulasan Pengguna
            </h2>
            <p><?= count($reviews) ?> ulasan dari traveler Wandee</p>
          </div>

          <button type="button" class="review-open-button" id="openReviewComments">
            Lihat ulasan
            <i data-lucide="chevron-right"></i>
          </button>
        </section>

      </div>

      <!-- KANAN -->
      <div class="detail-right-new">

        <section class="detail-panel detail-itinerary-panel">
          <h2>
            <i data-lucide="map"></i>
            Rencana Perjalanan
          </h2>
          <div class="detail-timeline">
            <?php foreach($itineraries as $item): ?>
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

        <section class="detail-panel">
          <h2>Fasilitas</h2>
          <div class="detail-facilities">
            <?php foreach($facilities as $fac): ?>
              <?php $icon = $facility_icons[$fac] ?? 'check-circle'; ?>
              <span>
                <i data-lucide="<?= $icon ?>"></i>
                <?= htmlspecialchars($fac) ?>
              </span>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="detail-join-card">
          <?php if ((int)($dest['quota'] ?? 0) > 0): ?>
            <div class="qty-select-wrapper" style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 10px;">
              <label for="ticketQty" style="font-size: 14px; font-weight: 500; color: #a0aec0;">Jumlah Peserta:</label>
              <div style="display: flex; align-items: center; gap: 8px;">
                <input type="number" id="ticketQty" value="1" min="1" max="<?= (int)($dest['quota'] ?? 0) ?>" 
                       style="width: 70px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; padding: 6px 10px; font-weight: 600; text-align: center;">
                <span style="font-size: 12px; color: #718096;">/ <?= (int)($dest['quota'] ?? 0) ?> slot</span>
              </div>
            </div>
          <?php endif; ?>
          <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 15px;">
            <div>
              <span>Total Harga</span>
              <strong id="displayTotalPrice">Rp <?= number_format((int)($dest['price'] ?? 0), 0, ',', '.') ?></strong>
            </div>
          </div>
          <?php if ((int)($dest['quota'] ?? 0) > 0): ?>
            <a href="/wandee/user/payment?id=<?= (int)$dest['id'] ?>&people=1" id="btnJoinTrip" class="btn-primary">Ikut Perjalanan</a>
          <?php else: ?>
            <button class="btn-primary" disabled style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: rgba(232, 240, 235, 0.32); cursor: not-allowed;">Kuota Penuh</button>
          <?php endif; ?>
        </section>

      </div>

    </section>

  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>
  <script src="/wandee/public/assets/js/script.js"></script>

  <div id="reviewCommentsModal" class="review-comments-modal" aria-hidden="true">
    <div class="review-comments-backdrop" data-close-review-comments></div>
    <section class="review-comments-panel" role="dialog" aria-modal="true" aria-labelledby="reviewCommentsTitle">
      <header class="review-comments-head">
        <div>
          <h2 id="reviewCommentsTitle">Ulasan Pengguna</h2>
          <p><?= count($reviews) ?> ulasan untuk <?= htmlspecialchars($dest['title'] ?? 'destinasi ini') ?></p>
        </div>
        <button type="button" class="review-comments-close" data-close-review-comments aria-label="Tutup ulasan">
          <i data-lucide="x"></i>
        </button>
      </header>

      <?php if(!empty($reviews)): ?>
        <div class="reviews-list">
          <?php foreach($reviews as $rev): ?>
            <?php $isOwnReview = isset($rev['user_id']) && (int)$rev['user_id'] === (int)$user_id; ?>
            <article class="review-item <?= $isOwnReview ? 'is-own-review' : '' ?>">
              <div class="review-header">
                <div class="review-user">
                  <?php if(!empty($rev['user_photo'])): ?>
                    <img
                      src="/wandee/public/uploads/profile/<?= htmlspecialchars($rev['user_photo']) ?>"
                      alt="<?= htmlspecialchars($rev['user_name'] ?? 'User') ?>">
                  <?php else: ?>
                    <div class="user-avatar-empty">
                      <i data-lucide="user"></i>
                    </div>
                  <?php endif; ?>

                  <div>
                    <strong><?= htmlspecialchars($rev['user_name'] ?? 'User Wandee') ?></strong>
                    <small>
                      <?= !empty($rev['created_at']) ? date('d M Y', strtotime($rev['created_at'])) : 'Baru saja' ?>
                    </small>
                  </div>
                </div>

                <div class="review-meta">
                  <?php if($isOwnReview): ?>
                    <span class="own-review-badge">Ulasan Anda</span>
                  <?php endif; ?>
                  <span class="review-rating">
                    &#9733; <?= number_format((float)($rev['rating'] ?? 0), 1) ?>
                  </span>
                </div>
              </div>

              <div class="review-content">
                <p><?= nl2br(htmlspecialchars($rev['review_text'] ?? '')) ?></p>

                <?php if(!empty($rev['review_image'])): ?>
                  <div class="review-photo-wrap">
                    <img
                      src="/wandee/public/uploads/reviews/<?= htmlspecialchars($rev['review_image']) ?>"
                      alt="Foto ulasan"
                      onclick="openReviewLightbox(this.src)">
                  </div>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="reviews-empty">
          <i data-lucide="message-square-off"></i>
          <p>Belum ada ulasan untuk destinasi ini.</p>
        </div>
      <?php endif; ?>
    </section>
  </div>

  <div id="reviewLightbox" class="lightbox-modal">
    <span class="lightbox-close" aria-label="Tutup" role="button" tabindex="0">&times;</span>
    <img class="lightbox-content" id="lightboxImage" alt="Foto ulasan">
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const lightbox = document.getElementById('reviewLightbox');
      const lightboxImage = document.getElementById('lightboxImage');
      const closeButton = document.querySelector('.lightbox-close');
      const commentsModal = document.getElementById('reviewCommentsModal');
      const openCommentsButton = document.getElementById('openReviewComments');
      const closeCommentsButtons = document.querySelectorAll('[data-close-review-comments]');

      function openReviewComments() {
        if (!commentsModal) return;
        commentsModal.classList.add('is-open');
        commentsModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
      }

      function closeReviewComments() {
        if (!commentsModal) return;
        commentsModal.classList.remove('is-open');
        commentsModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
      }

      function closeReviewLightbox() {
        if (!lightbox || !lightboxImage) return;
        lightbox.style.opacity = '0';
        lightboxImage.style.transform = 'scale(0.9)';
        setTimeout(function() {
          lightbox.style.display = 'none';
        }, 300);
      }

      window.openReviewLightbox = function(src) {
        if (!lightbox || !lightboxImage) return;
        lightboxImage.src = src;
        lightbox.style.display = 'flex';
        lightbox.offsetHeight;
        lightbox.style.opacity = '1';
        lightboxImage.style.transform = 'scale(1)';
      };

      if (closeButton) {
        closeButton.addEventListener('click', closeReviewLightbox);
        closeButton.addEventListener('keydown', function(event) {
          if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            closeReviewLightbox();
          }
        });
      }

      if (lightbox) {
        lightbox.addEventListener('click', function(event) {
          if (event.target === lightbox) {
            closeReviewLightbox();
          }
        });
      }

      if (openCommentsButton) {
        openCommentsButton.addEventListener('click', openReviewComments);
      }

      // Dynamic quantity calculation
      const ticketQty = document.getElementById('ticketQty');
      const displayTotalPrice = document.getElementById('displayTotalPrice');
      const btnJoinTrip = document.getElementById('btnJoinTrip');
      const basePrice = <?= (int)($dest['price'] ?? 0) ?>;
      const destinationId = <?= (int)($dest['id'] ?? 0) ?>;
      const maxQuota = <?= (int)($dest['quota'] ?? 0) ?>;

      if (ticketQty && displayTotalPrice && btnJoinTrip) {
        function updatePrice() {
          let qty = parseInt(ticketQty.value);
          if (isNaN(qty) || qty < 1) {
            qty = 1;
          }
          if (qty > maxQuota) {
            qty = maxQuota;
            ticketQty.value = maxQuota;
          }
          
          const total = basePrice * qty;
          displayTotalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
          btnJoinTrip.href = '/wandee/user/payment?id=' + destinationId + '&people=' + qty;
        }

        ticketQty.addEventListener('input', updatePrice);
        ticketQty.addEventListener('change', function() {
          let qty = parseInt(ticketQty.value);
          if (isNaN(qty) || qty < 1) {
            qty = 1;
            ticketQty.value = 1;
          }
          updatePrice();
        });
      }

      closeCommentsButtons.forEach(function(button) {
        button.addEventListener('click', closeReviewComments);
      });

      document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && lightbox && lightbox.style.display === 'flex') {
          closeReviewLightbox();
        } else if (event.key === 'Escape' && commentsModal && commentsModal.classList.contains('is-open')) {
          closeReviewComments();
        }
      });

      lucide.createIcons();
    });
  </script>
</body>
</html>
