<?php
session_start();
require 'functions.php';

$title = 'Login';
include_once('layouts/head_tag.php');

// jika ada session login kembalikan ke dashboard
if (isset($_SESSION["login"])) {
  header("Location: views/index.php");
  exit;
}

if (isset($_POST["login"])) {
  if (login($_POST) > 0) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Login Berhasil!',
          text: 'Anda akan dialihkan ke halaman dashboard',
          showConfirmButton: false,
          timer: 1000
        }).then(function() {
          window.location = 'views/index.php';
        });
      </script>";
  } else {
    $error = true;
  }
}

?>
<section class="section">
  <div class="container mt-5">
    <h3 class="text-center">Praktikum PemWeb</h3>
    <div class="row">
      <div
        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img
            src="assets/img/stisla-fill.svg"
            alt="logo"
            width="100"
            class="shadow-light rounded-circle" />
        </div>

        <div class="card card-primary">
          <div class="card-header">
            <h4>Login</h4>
          </div>

          <?php if (isset($error)): ?>
            <div
              class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>&times;</span>
                </button>
                Username / Password Salah!
              </div>
            </div>
          <?php endif; ?>

          <div class="card-body">
            <form
              method="POST"
              action=""
              class="needs-validation"
              novalidate="">
              <div class="form-group">
                <label for="username">Username</label>
                <input
                  id="username"
                  type="text"
                  class="form-control"
                  name="username"
                  tabindex="1"
                  required
                  autofocus
                  placeholder="Masukkan username" />
                <div class="invalid-feedback">
                  Please fill in your username
                </div>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  name="password"
                  tabindex="2"
                  required
                  placeholder="Masukkan password" />
                <div class="invalid-feedback">
                  Please fill in your password
                </div>
              </div>

              <div class="form-group">
                <button
                  type="submit"
                  name="login"
                  class="btn btn-primary btn-lg btn-block"
                  tabindex="4">
                  Login
                </button>
              </div>
            </form>
            <div class="mt-2 text-muted text-center">
              Don't have an account?
              <a href="<?= BASEPATH; ?>register.php">Create One</a>
            </div>
          </div>
        </div>

      </div>
    </div>
    <?php include_once('layouts/footer.php') ?>
  </div>
</section>

<?php include_once('layouts/closed_tag.php') ?>