<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Masuk dan Daftar - Wandee</title>

  <!-- CSS -->

  <link
    rel="stylesheet"
    href="../assets/css/global.css">

  <link
    rel="stylesheet"
    href="../assets/css/auth.css">

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

  <?php include '../includes/navbar.php'; ?>


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

        <a
          href="../index.php"
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
          action="../process/auth_process.php"
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

        <div class="social-auth">

          <button
            class="btn-social"
            type="button">

            Google

          </button>


          <button
            class="btn-social"
            type="button">

            Apple

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
      class="auth-card"
      id="registerPanel"
      style="display:none;">


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
          action="../process/auth_process.php"
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

  </div>



  <?php include '../includes/footer.php'; ?>

  <!-- JS -->

  <script src="../assets/js/script.js"></script>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>

