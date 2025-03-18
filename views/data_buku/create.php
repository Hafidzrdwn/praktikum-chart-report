<?php

session_start();
require '../../functions.php';

$title = 'Tambah Buku Baru';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$kode_buku = generateCode('buku', 'kode_buku', 'BK');

// old input value
$old_judul = isset($_SESSION['old_judul']) ? $_SESSION['old_judul'] : '';
$old_pengarang = isset($_SESSION['old_pengarang']) ? $_SESSION['old_pengarang'] : '';
$old_tahun_terbit = isset($_SESSION['old_tahun_terbit']) ? $_SESSION['old_tahun_terbit'] : '';
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
        <h1>Tambah Data Buku</h1>
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
              <div class="section-title mt-0 mb-4">Tambah Buku Baru</div>
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
                    value="<?= $kode_buku; ?>"
                    required
                    readonly>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="judul">Judul Buku</label>
                      <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku"
                        value="<?= $old_judul; ?>"
                        required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="pengarang">Pengarang</label>
                      <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan nama pengarang"
                        value="<?= $old_pengarang; ?>"
                        required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="tahun_terbit">Tahun Terbit</label>
                      <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Masukkan tahun terbit"
                        value="<?= $old_tahun_terbit; ?>"
                        required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="kategori">Kategori</label>
                      <select class="form-control" id="kategori" name="kategori" required>
                        <?php
                        $categories = ['novel', 'komik', 'biografi', 'fiksi', 'non-fiksi', 'pemrograman', 'bisnis'];
                        ?>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php foreach ($categories as $category) : ?>
                          <option value="<?= $category; ?>"
                            <?= $old_kategori === $category ? 'selected' : ''; ?>><?= ucwords($category); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" name="create_buku" class="btn btn-success">Tambah Buku</button>
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
  $_SESSION['old_judul'],
  $_SESSION['old_pengarang'],
  $_SESSION['old_tahun_terbit'],
  $_SESSION['old_kategori']
);

?>