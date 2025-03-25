<?php
session_start();
require '../functions.php';

$title = 'Dashboard';
include_once('../layouts/head_tag.php');


if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$users_count = countData('users');
$books_count = countData('buku');
$categories_count = countData('kategori_buku');
$mahasiswa_count = countData('mahasiswa');

$terlaris = querySingle("SELECT b.judul, SUM(p.jumlah) AS total_terjual
              FROM penjualan p
              JOIN buku b ON p.buku_id = b.id
              GROUP BY p.buku_id, b.judul
              ORDER BY total_terjual DESC
              LIMIT 1");

$kb_terlaris = querySingle("SELECT kb.kategori, SUM(p.jumlah) AS total_terjual
                FROM penjualan p
                JOIN buku b ON p.buku_id = b.id
                JOIN kategori_buku kb ON b.kategori_id = kb.id
                GROUP BY b.kategori_id, kb.kategori
                ORDER BY total_terjual DESC
                LIMIT 1");

$pelanggan = querySingle("SELECT m.nama_lengkap, COUNT(p.id) AS total_transaksi
              FROM penjualan p
              JOIN mahasiswa m ON p.mahasiswa_id = m.id
              GROUP BY p.mahasiswa_id, m.nama_lengkap
              ORDER BY total_transaksi DESC
              LIMIT 1");

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../layouts/sidebar.php') ?>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Dashboard</h1>
      </div>

      <div class="section-body">
        <h2 class="section-title">Hi, <?= ucwords($_SESSION['fname']); ?>!</h2>
        <p class="section-lead">
          Welcome to the Dashboard page
        </p>
      </div>

      <!-- STATISTIC -->
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-dark">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Users</h4>
              </div>
              <div class="card-body"><?= $users_count; ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-tags"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Kategori</h4>
              </div>
              <div class="card-body"><?= $categories_count; ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-book"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Buku</h4>
              </div>
              <div class="card-body"><?= $books_count; ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Mahasiswa</h4>
              </div>
              <div class="card-body"><?= $mahasiswa_count; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1 py-3">
            <div class="card-icon bg-primary">
              <i class="fas fa-book-open"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Buku Paling Laris</h4>
              </div>
              <div class="card-body">
                <?= $terlaris['judul']; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1 py-3">
            <div class="card-icon bg-primary">
              <i class="fas fa-tag"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Kategori Paling Disukai</h4>
              </div>
              <div class="card-body">
                <?= $kb_terlaris['kategori']; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1 py-3">
            <div class="card-icon bg-primary">
              <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pelanggan Setia</h4>
              </div>
              <div class="card-body">
                <?= $pelanggan['nama_lengkap']; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 📊 CHARTS ROW -->
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Buku Per Kategori</h4>
            </div>
            <div class="card-body">
              <canvas id="booksCategoryChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Buku Per Tahun Terbit</h4>
            </div>
            <div class="card-body">
              <canvas id="booksYearChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include_once('../layouts/footer.php') ?>
</div>
<?php include_once('../layouts/closed_tag.php') ?>