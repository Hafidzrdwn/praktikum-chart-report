<?php

session_start();
require '../../functions.php';

$title = 'Data Kategori Buku';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// ambil data dari tabel buku
$query = "SELECT * FROM kategori_buku
          ORDER BY id DESC";
$categories = query($query);

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Kategori Buku</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-lg-12 text-right">
              <a href="<?= BASEPATH; ?>views/data_kategori_buku/create.php" class="btn btn-success">Tambah Kategori Baru <i class="fas fa-plus"></i></a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row align-items-center mb-3">
                <div class="col-lg-6">
                  <div class="section-title mt-0">List Data Kategori Buku</div>
                </div>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-nowrap">Kategori</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($categories) > 0) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($categories as $c) : ?>
                      <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $c['kategori']; ?></td>
                        <td class="text-nowrap">
                          <a href="<?= BASEPATH; ?>views/data_kategori_buku/edit.php?id=<?= $c['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="<?= BASEPATH; ?>views/data_kategori_buku/proses_kategori_buku.php?delete_KB=true&id=<?= $c['id']; ?>" class="btn btn-danger btnDeleteKBk">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="3" class="text-center">Data Kategori Buku tidak ditemukan.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include_once('../../layouts/footer.php') ?>
</div>
<!-- POPUP ALERT -->
<?php
if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
  echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[success]',
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Oke'
          });
        </script>";
  unset($_SESSION['success']);
} else if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '$_SESSION[errors]',
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Oke'
          });
        </script>";
  unset($_SESSION['errors']);
}
?>
<script>
  $(document).ready(function() {
    $(document).on('click', '.btnDeleteKBk', function(e) {
      e.preventDefault();
      var href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data Kategori akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });
</script>
<?php include_once('../../layouts/closed_tag.php') ?>