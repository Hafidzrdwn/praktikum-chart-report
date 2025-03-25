<?php

session_start();
require '../../functions.php';

$title = 'Edit Kategori Buku';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$category = ($id) ? getSingleData('kategori_buku', 'id', $id) : null;

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Edit Data Kategori Buku</h1>
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
              <div class="section-title mt-0 mb-4">Edit Kategori Buku</div>
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
                <input type="hidden" name="id" value="<?= ($category) ? $category['id'] : ''; ?>">
                <div class="form-group">
                  <label for="kategori">Kode Buku</label>
                  <input type="text" class="form-control" id="kategori" name="kategori"
                    value="<?= ($category) ? $category['kategori'] : ''; ?>"
                    required>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" name="edit_KB" class="btn btn-primary">Edit Kategori</button>
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