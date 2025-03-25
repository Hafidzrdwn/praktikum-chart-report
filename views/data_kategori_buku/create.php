<?php

session_start();
require '../../functions.php';

$title = 'Tambah Kategori Buku Baru';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// old input value
$old_kategori = isset($_SESSION['old_kategori']) ? $_SESSION['old_kategori'] : '';

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tambah Data Kategori Buku</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-lg-12 text-left">
              <a href="<?= BASEPATH; ?>views/data_kategori_buku/index.php" class="btn btn-dark">Kembali</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="section-title mt-0 mb-4">Tambah Kategori Buku Baru</div>
              <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="row mb-3 alert-row">
                  <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                      <?= $_SESSION['errors']; ?>
                    </div>
                  </div>
                </div>
              <?php
                unset($_SESSION['errors']);
              endif; ?>
              <form action="proses_kategori_buku.php" method="POST" autocomplete="off">
                <div class="form-group">
                  <label for="kategori">Kategori Buku</label>
                  <input type="text" class="form-control" id="kategori" name="kategori"
                    value="<?= $old_kategori; ?>"
                    required>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" name="create_KB" class="btn btn-success">Tambah Kategori</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include_once('../../layouts/footer.php') ?>
</div>
<?php include_once('../../layouts/closed_tag.php') ?>

<?php
// clear old input value
unset(
  $_SESSION['old_kategori']
);

?>