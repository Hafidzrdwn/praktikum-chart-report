<?php
session_start();

require '../../functions.php';

// middleware
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['create_KB'])) {
  $kategori = htmlspecialchars(trim($_POST['kategori']));

  // old input value
  $_SESSION['old_kategori'] = $kategori;

  if (empty($kategori)) {
    $_SESSION['errors'] = 'Pastikan input sudah diisi!';
    header('Location: create.php');
    exit;
  }

  // clear old input value if passed
  unset(
    $_SESSION['old_kategori']
  );

  $data = [
    'kategori' => $kategori
  ];

  if (insertData('kategori_buku', $data) > 0) {
    $_SESSION['success'] = 'Data Kategori berhasil ditambahkan!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data Kategori gagal ditambahkan!';
    header('Location: create.php');
    exit;
  }
}

if (isset($_POST['edit_KB'])) {
  $id = $_POST['id'];
  $kategori = htmlspecialchars(trim($_POST['kategori']));

  if (empty($kategori)) {
    $_SESSION['errors'] = 'Pastikan input sudah diisi!';
    header("Location: edit.php?id=$id");
    exit;
  }

  $data = [
    'kategori' => $kategori
  ];

  if (updateData('kategori_buku', $data, 'id', $id) > 0) {
    $_SESSION['success'] = 'Data Kategori berhasil diubah!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data Kategori gagal diubah!';
    header("Location: edit.php?id=$id");
    exit;
  }
}

if (isset($_GET['delete_KB'])) {
  $id = $_GET['id'];

  if (deleteData('kategori_buku', 'id', $id) > 0) {
    $_SESSION['success'] = 'Data Kategori berhasil dihapus!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Data Kategori gagal dihapus!';
    header('Location: index.php');
    exit;
  }
}
