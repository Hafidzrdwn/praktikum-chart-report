<?php

session_start();
require '../../functions.php';

$title = 'Data Mahasiswa';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// ambil data dari tabel buku
$query = "SELECT m.id, m.nama_lengkap, p.provinsi, j.nama AS jurusan FROM mahasiswa m
          LEFT JOIN provinces p ON m.provinsi_id = p.id
          LEFT JOIN jurusan j ON m.jurusan_id = j.id
          ORDER BY m.id DESC";
$mahasiswa = query($query);

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Mahasiswa</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row align-items-center mb-3">
                <div class="col-lg-6">
                  <div class="section-title mt-0">List Data Mahasiswa</div>
                </div>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-nowrap">Nama Lengkap</th>
                    <th class="text-nowrap" scope="col">Asal Provinsi</th>
                    <th class="text-nowrap" scope="col">Program Studi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($mahasiswa) > 0) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($mahasiswa as $m) : ?>
                      <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= ucwords($m['nama_lengkap']); ?></td>
                        <td class="text-nowrap"><?= ucwords($m['provinsi']); ?></td>
                        <td><?= ucwords($m['jurusan']); ?></td>
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="4" class="text-center">Data Mahasiswa tidak ditemukan.</td>
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
<?php include_once('../../layouts/closed_tag.php') ?>