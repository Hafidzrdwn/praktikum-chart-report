  <?php
  require 'functions.php';
  $title = 'Logout';
  include_once('layouts/head_tag.php');

  session_start();
  $_SESSION = [];
  session_unset();
  session_destroy();

  setcookie('id', '', time() - 3600);
  setcookie('key', '', time() - 3600);

  // echo swal and redirect to login.php
  echo "<script>
  Swal.fire({
    title: 'Berhasil Logout',
    text: 'Anda akan dialihkan ke halaman login',
    icon: 'success',
    confirmButtonText: 'OK',
    confirmButtonColor: '#6777ef'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = 'login.php';
    }
  });
</script>";

  exit;
