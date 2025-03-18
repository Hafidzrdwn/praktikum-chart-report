<?php

session_start();
require '../../functions.php';

$title = 'Data Buku';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// ambil data dari tabel buku
$query = "SELECT * FROM buku ORDER BY id DESC";
$books = query($query);

?>
<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Buku</h1>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-lg-12 text-right">
              <a href="<?= BASEPATH; ?>views/data_buku/create.php" class="btn btn-success">Tambah Buku Baru <i class="fas fa-plus"></i></a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row align-items-center mb-3">
                <div class="col-lg-6">
                  <div class="section-title mt-0">List Data Buku</div>
                </div>
                <div class="col-lg-6">
                  <div class="row align-items-center">
                    <div class="col-lg-4 text-nowrap">
                      Urutkan berdasarkan:
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control w-100" id="sort" autocomplete="off">
                        <option value="created_at">Tanggal Input</option>
                        <option value="tahun_terbit">Tahun Terbit</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode</th>
                    <th class="text-nowrap" scope="col">Judul Buku</th>
                    <th scope="col">Pengarang</th>
                    <th class="text-nowrap" scope="col">Tahun Terbit</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($books) > 0) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($books as $book) : ?>
                      <tr>
                        <th scope="row"><?= $i; ?></th>
                        <?php
                        $kode_buku = explode('-', $book['kode_buku'])[0];
                        ?>
                        <td><?= $kode_buku; ?></td>
                        <td><?= $book['judul']; ?></td>
                        <td class="text-nowrap"><?= ucwords($book['pengarang']); ?></td>
                        <td><?= $book['tahun_terbit']; ?></td>
                        <td><?= ucwords($book['kategori']); ?></td>
                        <td class="text-nowrap">
                          <a href="<?= BASEPATH; ?>views/data_buku/edit.php?kd=<?= $book['kode_buku']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="<?= BASEPATH; ?>views/data_buku/proses_buku.php?delete_buku=true&kd=<?= $book['kode_buku']; ?>" class="btn btn-danger btnDelete">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="6" class="text-center">Data Buku tidak ditemukan.</td>
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
    function capitalizeFirstLetter(str) {
      return str[0].toUpperCase() + str.slice(1);
    }

    function sortData(sort) {
      $.ajax({
        url: 'proses_buku.php',
        type: 'POST',
        data: {
          sort_buku: sort
        },
        success: function(data) {
          var books = JSON.parse(data);
          var html = '';
          var i = 1;

          if (books.length > 0) {
            books.forEach(book => {
              let kode_buku = book.kode_buku.split('-')[0];
              html += `
                <tr>
                  <th scope="row">${i}</th>
                  <td>${kode_buku}</td>
                  <td>${capitalizeFirstLetter(book.judul)}</td>
                  <td class="text-nowrap">${capitalizeFirstLetter(book.pengarang)}</td>
                  <td>${book.tahun_terbit}</td>
                  <td>${capitalizeFirstLetter(book.kategori)}</td>
                  <td class="text-nowrap">
                    <a href="<?= BASEPATH; ?>views/data_buku/edit.php?kd=${book.kode_buku}" class="btn btn-primary">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= BASEPATH; ?>views/data_buku/proses_buku.php?delete_buku=true&kd=${book.kode_buku}" class="btn btn-danger btnDelete">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              `;
              i++;
            });
          } else {
            html += `
              <tr>
                <td colspan="6" class="text-center">Data Buku tidak ditemukan.</td>
              </tr>
            `;
          }

          $('tbody').html(html);
        }
      });
    }

    $('#sort').change(function() {
      var sort = $(this).val();
      sortData(sort);
    });

    $(document).on('click', '.btnDelete', function(e) {
      e.preventDefault();
      var href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data buku akan dihapus secara permanen!",
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