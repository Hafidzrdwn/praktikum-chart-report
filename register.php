<?php
session_start();
require 'functions.php';

// jika ada session login kembalikan ke dashboard
if (isset($_SESSION["login"])) {
  header("Location: views/index.php");
  exit;
}

$title = 'Registrasi';
include_once('layouts/head_tag.php');

if (isset($_POST["register"])) {

  if (registrasi($_POST) > 0) {
    echo "<script>
				
        Swal.fire({
          icon: 'success',
          title: 'Registrasi Berhasil',
          text: 'Silahkan login',
          showConfirmButton: false,
          timer: 1500
        }).then(function() {
          window.location = 'login.php';
        });

			  </script>";
  } else {
    echo mysqli_error($conn);
  }
}
?>
<section class="section">
  <div class="container mt-5">
    <h3 class="text-center">Praktikum PWeb - Paralel C</h3>
    <div class="row">
      <div
        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="login-brand">
          <img
            src="assets/img/stisla-fill.svg"
            alt="logo"
            width="100"
            class="shadow-light rounded-circle" />
        </div>

        <div class="card card-primary">
          <div class="card-header">
            <h4>Register</h4>
          </div>

          <div class="card-body">
            <form method="POST" action="">
              <div class="row">
                <div class="form-group col-6">
                  <label for="username">Username</label>
                  <input
                    id="username"
                    type="text"
                    class="form-control"
                    name="username"
                    autofocus
                    placeholder="Masukkan Username" />
                </div>
                <div class="form-group col-6">
                  <label for="fullname">Nama Lengkap</label>
                  <input
                    id="fullname"
                    type="text"
                    class="form-control"
                    name="fullname"
                    placeholder="Masukkan Nama Lengkap" />
                </div>
              </div>

              <div class="row">
                <div class="form-group col-6">
                  <label for="password" class="d-block">Password</label>
                  <input
                    id="password"
                    type="password"
                    class="form-control pwstrength"
                    data-indicator="pwindicator"
                    name="password"
                    placeholder="Masukkan Password" />
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <label for="password2" class="d-block">Konfirmasi Password</label>
                  <input
                    id="password2"
                    type="password"
                    class="form-control"
                    name="password-confirm"
                    placeholder="Masukkan Konfirmasi Password" />
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input
                    type="checkbox"
                    name="agree"
                    class="custom-control-input"
                    id="agree" />
                  <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                </div>
              </div>

              <div class="form-group">
                <button
                  type="submit"
                  name="register"
                  class="btn btn-primary btn-lg btn-block">
                  Register
                </button>
              </div>
            </form>

            <div class="mt-3 mb-3 text-muted text-center">
              Already have an account?
              <a href="<?= BASEPATH; ?>login.php">Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include_once('layouts/footer.php'); ?>

<?php include_once('layouts/closed_tag.php') ?>