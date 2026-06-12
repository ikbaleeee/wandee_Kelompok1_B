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



        <!-- REGISTER FORM -->


        <form
          action="/wandee/auth/register"
          method="POST">


          <input
            type="hidden"
            name="action"
            value="register">




          <!-- NAME -->


          <div class="form-group">


            <input
              type="text"
              class="form-input"
              name="name"
              placeholder="Nama Lengkap"
              required>


          </div>






          <!-- EMAIL -->


          <div class="form-group">


            <input
              type="email"
              class="form-input"
              name="email"
              placeholder="Email"
              required>


          </div>






          <!-- PASSWORD -->


          <div class="form-group">


            <input
              type="password"
              class="form-input"
              name="password"
              placeholder="Password"
              required>


          </div>






          <!-- BUTTON -->


          <button
            class="btn-submit"
            type="submit">


            Daftar


          </button>


        </form>






        <!-- SWITCH -->


        <p class="auth-footer-link">


          Sudah punya akun?


          <a href="#" id="showLoginText">


            Masuk sekarang


          </a>


        </p>


      </div>


    </div>




    <!-- FORGOT PANEL -->


    <div class="auth-card auth-card-hidden" id="forgotPanel">


      <!-- LEFT -->


      <div class="auth-left">


        <div class="auth-left-text">


          <h2>


            Atur ulang sandi akun Anda.


          </h2>


          <p>


            Masukkan email terdaftar dan buat password baru Anda di Wandee.


          </p>


        </div>


      </div>






      <!-- RIGHT -->


      <div class="auth-right">


        <a
          href="#"
          class="auth-back"
          id="showLoginFromForgot">


          <i data-lucide="arrow-left"></i>


          Kembali ke Masuk


        </a>






        <h1>


          Reset Password


        </h1>






        <p class="sub">


          Perbarui password akun Anda


        </p>






        <!-- FORGOT FORM -->


        <form
          action="/wandee/auth/reset_password"
          method="POST">






          <!-- EMAIL -->


          <div class="form-group">


            <span class="form-icon">


              <i data-lucide="mail"></i>


            </span>


            <input
              type="email"
              class="form-input"
              name="email"
              placeholder="Email Terdaftar"
              required>


          </div>






          <!-- NEW PASSWORD -->


          <div class="form-group">


            <span class="form-icon">


              <i data-lucide="lock-keyhole"></i>


            </span>


            <input
              type="password"
              class="form-input"
              name="password"
              placeholder="Password Baru"
              required>


          </div>






          <!-- CONFIRM PASSWORD -->


          <div class="form-group">


            <span class="form-icon">


              <i data-lucide="lock-keyhole"></i>


            </span>


            <input
              type="password"
              class="form-input"
              name="confirm_password"
              placeholder="Konfirmasi Password Baru"
              required>


          </div>






          <!-- BUTTON -->


          <button
            class="btn-submit"
            type="submit">


            Reset Password


          </button>






        </form>


      </div>


    </div>


  </div>






  <?php require __DIR__ . '/partials/footer.php'; ?>


  <!-- JS -->


  <script src="/wandee/public/assets/js/script.js?v=<?= time() ?>"></script>


  <script>
    lucide.createIcons();


    const authErrorPopup = document.getElementById('authErrorPopup');
    const closeAuthErrorPopup = document.getElementById('closeAuthErrorPopup');


    if (closeAuthErrorPopup && authErrorPopup) {
      closeAuthErrorPopup.addEventListener('click', function() {
        authErrorPopup.classList.remove('is-open');
      });
    }


    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && authErrorPopup?.classList.contains('is-open')) {
        authErrorPopup.classList.remove('is-open');
      }
    });


    // Login/Register/Forgot transitions
    const showForgotBtn = document.getElementById('showForgot');
    const showLoginFromForgotBtn = document.getElementById('showLoginFromForgot');
    const loginPanelEl = document.getElementById('loginPanel');
    const registerPanelEl = document.getElementById('registerPanel');
    const forgotPanelEl = document.getElementById('forgotPanel');


    if(showForgotBtn && loginPanelEl && forgotPanelEl){
      showForgotBtn.addEventListener('click', function(e){
        e.preventDefault();
        loginPanelEl.classList.add('auth-card-hidden');
        registerPanelEl.classList.add('auth-card-hidden');
        forgotPanelEl.classList.remove('auth-card-hidden');
      });
    }


    if(showLoginFromForgotBtn && loginPanelEl && forgotPanelEl){
      showLoginFromForgotBtn.addEventListener('click', function(e){
        e.preventDefault();
        forgotPanelEl.classList.add('auth-card-hidden');
        loginPanelEl.classList.remove('auth-card-hidden');
      });
    }
  </script>


</body>
</html>

