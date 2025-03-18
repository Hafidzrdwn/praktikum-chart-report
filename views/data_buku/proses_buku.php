<?php
session_start();

require '../../functions.php';

// middleware
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['create_buku'])) {
  $kode_buku = htmlspecialchars(trim($_POST['kode_buku']));
  $judul = htmlspecialchars(trim($_POST['judul']));
  $pengarang = htmlspecialchars(trim($_POST['pengarang']));
  $tahun_terbit = htmlspecialchars(trim($_POST['tahun_terbit']));
  $kategori = htmlspecialchars(trim($_POST['kategori']));

  // old input value
  $_SESSION['old_judul'] = $judul;
  $_SESSION['old_pengarang'] = $pengarang;
  $_SESSION['old_tahun_terbit'] = $tahun_terbit;
  $_SESSION['old_kategori'] = $kategori;

  if (empty($kode_buku) || empty($judul) || empty($pengarang) || empty($tahun_terbit) || empty($kategori)) {
    $_SESSION['errors'] = 'Pastikan semua kolom sudah diisi!';
    header('Location: create.php');
    exit;
  }

  // clear old input value if passed
  unset(
    $_SESSION['old_judul'],
    $_SESSION['old_pengarang'],
    $_SESSION['old_tahun_terbit'],
    $_SESSION['old_kategori']
  );

  $data = [
    'kode_buku' => $kode_buku,
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun_terbit' => $tahun_terbit,
    'kategori' => $kategori
  ];

  if (insertData('buku', $data) > 0) {
    $_SESSION['success'] = 'Data buku berhasil ditambahkan!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data buku gagal ditambahkan!';
    header('Location: create.php');
    exit;
  }
}

if (isset($_POST['edit_buku'])) {
  $kode = $_POST['kode_buku'];
  $judul = htmlspecialchars(trim($_POST['judul']));
  $pengarang = htmlspecialchars(trim($_POST['pengarang']));
  $tahun_terbit = htmlspecialchars(trim($_POST['tahun_terbit']));
  $kategori = htmlspecialchars(trim($_POST['kategori']));

  if (empty($kode) || empty($judul) || empty($pengarang) || empty($tahun_terbit) || empty($kategori)) {
    $_SESSION['errors'] = 'Pastikan semua kolom sudah diisi!';
    header("Location: edit.php?kd=$kode");
    exit;
  }

  $data = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun_terbit' => $tahun_terbit,
    'kategori' => $kategori
  ];

  if (updateData('buku', $data, 'kode_buku', $kode) > 0) {
    $_SESSION['success'] = 'Data buku berhasil diubah!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data buku gagal diubah!';
    header("Location: edit.php?kd=$kode");
    exit;
  }
}

if (isset($_GET['delete_buku'])) {
  $kode = $_GET['kd'];

  if (deleteData('buku', 'kode_buku', $kode) > 0) {
    $_SESSION['success'] = 'Data buku berhasil dihapus!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data buku gagal dihapus!';
    header('Location: index.php');
    exit;
  }
}

if (isset($_POST['sort_buku'])) {
  $sort = $_POST['sort_buku'];

  if ($sort === 'created_at') {
    $query = "SELECT * FROM buku ORDER BY id DESC";
  } else {
    $query = "SELECT * FROM buku ORDER BY tahun_terbit DESC";
  }

  $books = query($query);

  echo json_encode($books);
  exit;
}
