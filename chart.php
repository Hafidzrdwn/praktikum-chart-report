<?php
session_start();
require 'functions.php';


if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if (isset($_GET['books_chart_category'])) {
  $query = "SELECT k.kategori, COUNT(b.id) as total 
          FROM buku b 
          JOIN kategori_buku k ON b.kategori_id = k.id
          GROUP BY k.id, k.kategori";
  $result = query($query);

  $data = [];
  foreach ($result as $row) {
    $dt_books[] = [
      'category' => ucwords($row['kategori']),
      'total' => $row['total']
    ];
  }

  $data = [
    'books' => $dt_books,
    'totalData' => countData('buku')
  ];

  echo json_encode($data);
  exit;
}

if (isset($_GET['books_year_chart'])) {
  $query = "SELECT tahun_terbit, COUNT(*) as total FROM buku GROUP BY tahun_terbit ORDER BY tahun_terbit ASC";
  $result = query($query);

  echo json_encode($result);
  exit;
}
