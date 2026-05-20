<?php

session_start();

include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/loginregister.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran - Wandee</title>

  <link rel="stylesheet" href="../assets/css/global.css">
  <link rel="stylesheet" href="../assets/css/detail.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .payment-deadline {
      display: none;
      opacity: 0;
      transform: translateY(-12px);
      transition: opacity .4s ease, transform .4s ease;
      margin-bottom: 24px;
    }

    .payment-deadline.visible {
      display: flex;
      opacity: 1;
      transform: translateY(0);
    }

    /* Animasi masuk */
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-14px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .payment-deadline.animate {
      animation: slideDown .4s ease forwards;
    }
    .payment-method {
      cursor: pointer;
    }
  </style>
</head>

<body class="payment-page">
  <?php include '../includes/navbar.php'; ?>

  <main class="payment-shell">

    <section class="payment-deadline" id="paymentDeadline">
      <span class="payment-deadline-icon">
        <i data-lucide="clock-3"></i>
      </span>
      <p>
        Selesaikan pembayaran dalam
        <strong id="countdown">59:00</strong>
        <span>jika melewati batas waktu, pembayaran dianggap gagal dan booking kamu akan dibatalkan.</span>
      </p>
    </section>

    <!-- INFO TRIP -->
    <section class="payment-trip-card">

      <img src="../assets/img/bromo.png" alt="Pemandangan Bromo">

      <div class="payment-trip-info">
        <h1>Perjalanan Bromo & Malang</h1>
        <p><i data-lucide="map-pin"></i> Malang, Jawa Timur</p>
        <p><i data-lucide="calendar-days"></i> 01 - 03 Mei 2026</p>
        <span><i data-lucide="badge-check"></i> Perjalanan Mendatang</span>
      </div>

      <div class="payment-trip-price">
        <div>
          <span>Harga per orang</span>
          <strong>Rp3.000.000</strong>
        </div>
        <div>
          <span>Jumlah peserta</span>
          <strong>1 Orang</strong>
        </div>
        <div class="payment-total-line">
          <span>Total Pembayaran</span>
          <strong>Rp3.000.000</strong>
        </div>
      </div>

    </section>

    <section class="payment-grid">

      <div class="payment-main">

        <!-- RINCIAN -->
        <section class="payment-panel">
          <h2>Rincian Pembayaran</h2>
          <div class="payment-row">
            <span>Harga per orang</span>
            <strong>Rp3.000.000</strong>
          </div>
          <div class="payment-row">
            <span>Jumlah peserta</span>
            <strong>1 Orang</strong>
          </div>
          <div class="payment-row payment-row-total">
            <span>Total Pembayaran</span>
            <strong>Rp3.000.000</strong>
          </div>
        </section>

        <section class="payment-panel">
          <h2>Metode Pembayaran</h2>

          <div class="payment-methods">

            <label class="payment-method">
              <input type="radio" name="payment" value="bca">
              <span class="payment-radio"></span>
              <strong>BCA</strong>
              <span>Bank BCA</span>
            </label>

            <label class="payment-method">
              <input type="radio" name="payment" value="bri">
              <span class="payment-radio"></span>
              <strong>BRI</strong>
              <span>Bank BRI</span>
            </label>

            <label class="payment-method">
              <input type="radio" name="payment" value="bni">
              <span class="payment-radio"></span>
              <i data-lucide="landmark"></i>
              <span>Bank BNI</span>
            </label>

            <label class="payment-method">
              <input type="radio" name="payment" value="kartu">
              <span class="payment-radio"></span>
              <i data-lucide="credit-card"></i>
              <span>Kartu Debit/Kredit</span>
            </label>

            <label class="payment-method payment-method-wide">
              <input type="radio" name="payment" value="qris">
              <span class="payment-radio"></span>
              <i data-lucide="qr-code"></i>
              <span>QRIS Semua Pembayaran</span>
            </label>

          </div>

          <p id="methodError" style="display:none; margin-top:12px; color:#ff6b6b; font-size:.82rem; font-weight:600;">
            ⚠ Pilih metode pembayaran terlebih dahulu.
          </p>

        </section>

      </div>

      <aside class="payment-summary">

        <h2>Ringkasan Pesanan</h2>

        <div class="payment-row">
          <span>Harga per orang</span>
          <strong>Rp3.000.000</strong>
        </div>

        <div class="payment-row">
          <span>Jumlah peserta</span>
          <strong>1 Orang</strong>
        </div>

        <div class="payment-row payment-summary-total">
          <span>Jumlah Bayar</span>
          <strong>Rp3.000.000</strong>
        </div>

        <div class="payment-promo">
          <label for="promoCode">Promo / Voucher</label>
          <div>
            <input type="text" id="promoCode" placeholder="Gunakan kode promo">
            <button type="button">Pakai</button>
          </div>
        </div>

        <div class="payment-note">
          <h3>Informasi Penting</h3>
          <p><i data-lucide="check-circle-2"></i> Pemesanan ini tidak termasuk fasilitas penginapan di Wandee.</p>
          <p><i data-lucide="check-circle-2"></i> Rasakan pengalaman seru menjelajahi pesona alam serta berbagai destinasi wisata favorit.</p>
          <p><i data-lucide="check-circle-2"></i> Pembayaran dijamin aman dan terenkripsi.</p>
        </div>

        <button class="btn-primary payment-pay-button" id="payBtn">
          <i data-lucide="lock"></i>
          Bayar Sekarang
        </button>

      </aside>

    </section>

  </main>

  <?php include '../includes/footer.php'; ?>

  <script src="../assets/js/script.js"></script>

  <script>
   
    // ACTIVE STATE saat pilih metode pembayaran
    const methods = document.querySelectorAll('.payment-method input[type="radio"]');
    methods.forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.payment-method').forEach(l => l.classList.remove('active'));
        radio.closest('.payment-method').classList.add('active');
        document.getElementById('methodError').style.display = 'none';
      });
    });

    // BAYAR SEKARANG — validasi lalu tampilkan timer
    const payBtn       = document.getElementById('payBtn');
    const deadline     = document.getElementById('paymentDeadline');
    const countdownEl  = document.getElementById('countdown');
    let countdownTimer = null;
    let timerStarted   = false;

    payBtn.addEventListener('click', () => {
      const selected = document.querySelector('input[name="payment"]:checked');

    
      if (!selected) {
        document.getElementById('methodError').style.display = 'block';
        return;
      }


      if (timerStarted) return;
      timerStarted = true;

      deadline.classList.add('visible', 'animate');

      deadline.scrollIntoView({ behavior: 'smooth', block: 'center' });

      let totalSeconds = 59 * 60;

      function updateCountdown() {
        const m = Math.floor(totalSeconds / 60);
        const s = totalSeconds % 60;
        countdownEl.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;

        if (totalSeconds <= 0) {
          clearInterval(countdownTimer);
          countdownEl.textContent = '00:00';
          countdownEl.style.color = '#ff6b6b';
          return;
        }
        totalSeconds--;
      }

      updateCountdown();
      countdownTimer = setInterval(updateCountdown, 1000);

      payBtn.innerHTML = '<i data-lucide="loader"></i> Memproses...';
      payBtn.disabled = true;
      lucide.createIcons();
    });
  </script>

</body>
</html>
