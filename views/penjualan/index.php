<?php

session_start();
require '../../functions.php';

$title = 'Transaksi Penjualan Buku';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Transaksi Penjualan</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="section-title mt-0 mb-4">Tambah Transaksi</div>
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
              <form action="proses_penjualan.php" method="POST" autocomplete="off">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <?php
                      $mahasiswa = query("SELECT id, nama_lengkap FROM mahasiswa");
                      ?>
                      <label for="nama_mhs">Nama Mahasiswa</label>
                      <select class="form-control" id="nama_mhs" name="mahasiswa_id" required>
                        <option value="" disabled selected>Pilih Mahasiswa</option>
                        <?php foreach ($mahasiswa as $m) : ?>
                          <option value="<?= $m['id']; ?>"><?= ucwords($m['nama_lengkap']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <?php
                      $books = query("SELECT id, kode_buku, judul, harga FROM buku");
                      ?>
                      <label for="buku">Judul Buku</label>
                      <select class="form-control" id="buku" name="buku_id" required>
                        <option value="" disabled selected>Pilih Buku</option>
                        <?php foreach ($books as $b) : ?>
                          <option value="<?= $b['id']; ?>" data-price="<?= $b['harga']; ?>"><?= $b['kode_buku'] . " - " . ucwords($b['judul']); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="jumlah">Jumlah Beli</label>
                      <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah beli"
                        required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="total_harga">Total Harga</label>
                      <input type="text" class="form-control" id="total_harga"
                        value="0" name="total_harga" readonly>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" name="create_penjualan" class="btn btn-success">Submit</button>
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
}
?>
<script>
  $(document).ready(function() {
    $("#buku, #jumlah").on("change keyup", function() {
      let hargaBuku = $("#buku option:selected").data("price") || 0;
      let jumlah = parseInt($("#jumlah").val()) || 0;
      let totalHarga = hargaBuku * jumlah;

      if (hargaBuku == 0 || jumlah == 0) {
        $("#total_harga").val("0");
        return;
      }

      $("#total_harga").val("Rp" + totalHarga.toLocaleString("id-ID"));
    });
  })
</script>
<?php include_once('../../layouts/closed_tag.php') ?>