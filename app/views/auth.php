<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Masuk dan Daftar - Wandee</title>

  <!-- CSS -->
  <link rel="stylesheet" href="/wandee/public/assets/css/styles.css?v=<?= time() ?>">

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

<body class="auth-page">

  <?php require __DIR__ . '/partials/navbar.php'; ?>

  <?php if(isset($_GET['error'])): ?>
    <?php
      $errorMessage = 'Email atau password yang Anda masukkan salah. Silakan coba lagi.';
      if($_GET['error'] === 'reset_empty') {
          $errorMessage = 'Email dan password wajib diisi untuk mereset.';
      } elseif($_GET['error'] === 'reset_mismatch') {
          $errorMessage = 'Konfirmasi password baru tidak cocok. Silakan coba lagi.';
      } elseif($_GET['error'] === 'reset_email_not_found') {
          $errorMessage = 'Email tidak terdaftar di sistem kami. Silakan periksa kembali.';
      }
    ?>
    <div class="auth-error-popup is-open" id="authErrorPopup" role="alertdialog" aria-modal="true">
      <div class="auth-error-card">
        <h2>Terjadi Kesalahan</h2>
        <p><?= htmlspecialchars($errorMessage) ?></p>
        <button class="btn-close-popup" id="closeAuthErrorPopup">Tutup</button>
      </div>
    </div>
  <?php elseif(isset($_GET['reset_success'])): ?>
    <div class="auth-error-popup is-open" id="authErrorPopup" role="alertdialog" aria-modal="true" style="border-color: #10b981;">
      <div class="auth-error-card" style="border-top: 4px solid #10b981;">
        <h2 style="color: #10b981;">Reset Berhasil</h2>
        <p>Password Anda berhasil diperbarui! Silakan masuk menggunakan password baru Anda.</p>
        <button class="btn-close-popup" id="closeAuthErrorPopup" style="background: #10b981;">Tutup</button>
      </div>
    </div>
  <?php endif; ?>

  <!-- AUTH WRAP -->

  <div class="auth-wrap">


    <!-- LOGIN PANEL -->

    <div class="auth-card" id="loginPanel">


      <!-- LEFT -->

      <div class="auth-left">

        <div class="auth-left-text">

          <h2>
            Selamat datang kembali,
            petualangan baru menunggumu.
          </h2>

          <p>
            Masuk untuk melanjutkan eksplorasi
            destinasi impian bersama Wandee.
          </p>

        </div>

      </div>



      <!-- RIGHT -->

      <div class="auth-right">

    <?php if(isset($_GET['expired'])): ?>
      <div class="session-expired-alert">
        Session Anda telah berakhir karena tidak ada aktivitas selama 5 menit.
        Silakan login kembali.
      </div>
    <?php endif; ?>

    <a
      href="/wandee/"
      class="auth-back">

          <i data-lucide="arrow-left"></i>

          Kembali

        </a>


        <h1>
          Masuk
        </h1>

        <p class="sub">
          Masukkan detail akun untuk masuk
        </p>



        <!-- LOGIN FORM -->

        <form
          action="/wandee/auth/login"
          method="POST">

          <input
            type="hidden"
            name="action"
            value="login">


          <!-- EMAIL -->

          <div class="form-group">

            <span class="form-icon">

              <i data-lucide="user"></i>

            </span>

            <input
              type="email"
              class="form-input"
              name="email"
              placeholder="Email"
              required>

          </div>



          <!-- PASSWORD -->

          <div class="form-group">

            <span class="form-icon">

              <i data-lucide="lock-keyhole"></i>

            </span>

            <input
              type="password"
              class="form-input"
              name="password"
              placeholder="Password"
              required>

          </div>

          <p class="auth-forgot-link" style="text-align: right; margin-top: -15px; margin-bottom: 20px; font-size: 13px;">
            <a href="#" id="showForgot" style="color: var(--accent, #38bdf8); text-decoration: none;">Lupa Password?</a>
          </p>

          <!-- BUTTON -->

          <button
            class="btn-submit"
            type="submit">

            Masuk

          </button>

        </form>



        <!-- DIVIDER -->

        <p class="auth-divider">
          -atau masuk dengan-
        </p>



        <!-- SOCIAL -->

        <div class="social-auth" style="grid-template-columns: 1fr;">

          <button
            class="btn-social"
            type="button"
            onclick="window.location.href='/wandee/auth/google'">

            Google

          </button>

        </div>



        <!-- SWITCH -->

        <p class="auth-footer-link">

          Tidak memiliki akun?

          <a href="#" id="showRegister">

            Daftar sekarang

          </a>

        </p>

      </div>

    </div>



    <!-- REGISTER PANEL -->

    <div
      class="auth-card auth-card-hidden"
      id="registerPanel">


      <!-- LEFT -->

      <div class="auth-left">

        <div class="auth-left-text">

          <h2>
            Mulai perjalananmu bersama Wandee.
          </h2>

          <p>
            Buat akun baru dan temukan
            pengalaman traveling terbaik.
          </p>

        </div>

      </div>



      <!-- RIGHT -->

      <div class="auth-right">

        <a
          href="#"
          class="auth-back"
          id="showLogin">

          <i data-lucide="arrow-left"></i>

          Kembali ke Masuk

        </a>


        <h1>
          Daftar
        </h1>

        <p class="sub">
          Buat akun baru sekarang
        </p>
