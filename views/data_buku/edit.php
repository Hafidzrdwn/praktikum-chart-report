<?php

session_start();
require '../../functions.php';

$title = 'Edit Buku';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$kode = isset($_GET['kd']) ? $_GET['kd'] : '';
$query_book = "SELECT b.*, k.kategori FROM
                buku b JOIN kategori_buku k ON b.kategori_id = k.id
                WHERE b.kode_buku = '$kode'
              ";
$book = ($kode) ? querySingle($query_book) : null;
$categories = query("SELECT * FROM kategori_buku");

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Edit Data Buku</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-lg-12 text-left">
              <a href="<?= BASEPATH; ?>views/data_buku/index.php" class="btn btn-dark">Kembali</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="section-title mt-0 mb-4">Edit Buku</div>
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
              <form action="proses_buku.php" method="POST" autocomplete="off">
                <div class="form-group">
                  <label for="kode_buku">Kode Buku</label>
                  <input type="text" class="form-control" id="kode_buku" name="kode_buku"
                    value="<?= ($book) ? $book['kode_buku'] : ''; ?>"
                    required
                    readonly>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="judul">Judul Buku</label>
                      <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku"
                        value="<?= ($book) ? $book['judul'] : ''; ?>"
                        required>
                    </div>
                  </div>
                  <div class=" col-lg-6">
                    <div class="form-group">
                      <label for="pengarang">Pengarang</label>
                      <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan nama pengarang"
                        value="<?= ($book) ? $book['pengarang'] : ''; ?>"
                        required>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="tahun_terbit">Tahun Terbit</label>
                      <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Masukkan tahun terbit"
                        value="<?= ($book) ? $book['tahun_terbit'] : ''; ?>"
                        required>
                    </div>
                  </div>
                  <div class=" col-lg-6">
                    <div class="form-group">
                      <label for="kategori">Kategori</label>
                      <select class="form-control" id="kategori" name="kategori" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php foreach ($categories as $c) : ?>
                          <option value="<?= $c['id']; ?>"
                            <?php $dt_category = ($book) ? $book['kategori_id'] : ''; ?>
                            <?= $dt_category === $c['id'] ? 'selected' : ''; ?>><?= ucwords($c['kategori']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="harga">Harga Buku</label>
                  <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga buku"
                    value="<?= $book['harga']; ?>"
                    required>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" name="edit_buku" class="btn btn-primary">Edit Buku</button>
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