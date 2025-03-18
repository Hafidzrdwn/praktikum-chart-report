<?php
session_start();
require '../../functions.php';

$title = 'Data Users';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// ambil data dari tabel users
$query = "SELECT * FROM users";
$users = query($query);

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Users</h1>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="section-title mt-0">List Data Pengguna</div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Lengkap</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($users) > 0) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $user) : ?>
                      <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $user['username']; ?></td>
                        <td><?= ucwords($user['fullname']); ?></td>
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="3" class="text-center">Data Pengguna tidak ditemukan.</td>
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