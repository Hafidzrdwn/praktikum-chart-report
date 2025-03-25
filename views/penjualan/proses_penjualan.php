<?php
session_start();

require '../../functions.php';

// middleware
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['create_penjualan'])) {
  $jumlah = htmlspecialchars(trim($_POST['jumlah']));
  $mhs_id = htmlspecialchars(trim($_POST['mahasiswa_id']));
  $buku_id = htmlspecialchars(trim($_POST['buku_id']));
  $total = htmlspecialchars(trim($_POST['total_harga']));
  $total_harga = rupiahToNumber($total);

  if (empty($jumlah) || empty($mhs_id) || empty($buku_id) || empty($total)) {
    $_SESSION['errors'] = 'Pastikan semua kolom sudah diisi!';
    header('Location: index.php');
    exit;
  }

  $data = [
    'jumlah' => $jumlah,
    'mahasiswa_id' => $mhs_id,
    'buku_id' => $buku_id,
    'total' => $total_harga
  ];

  if (insertData('penjualan', $data) > 0) {
    $_SESSION['success'] = 'Transaksi Berhasil!';
    header('Location: index.php');
    exit;
  } else {
    $_SESSION['errors'] = 'Transaksi Gagal!';
    header('Location: create.php');
    exit;
  }
}

if (isset($_GET['selling_month'])) {
  $bulan_default = [
    "01" => "Januari",
    "02" => "Februari",
    "03" => "Maret",
    "04" => "April",
    "05" => "Mei",
    "06" => "Juni",
    "07" => "Juli",
    "08" => "Agustus",
    "09" => "September",
    "10" => "Oktober",
    "11" => "November",
    "12" => "Desember"
  ];

  $sales_per_month = query("SELECT DATE_FORMAT(created_at, '%m') AS bulan, SUM(jumlah) AS total_penjualan
                          FROM penjualan
                          GROUP BY bulan");

  $data = [];

  foreach ($bulan_default as $num => $name) {
    $data[$num] = ['bulan' => $name, 'total_penjualan' => 0];
  }

  foreach ($sales_per_month as $row) {
    $bulan_num = $row['bulan'];
    $data[$bulan_num]['total_penjualan'] = (int) $row['total_penjualan'];
  }

  $data = array_values($data);

  header('Content-Type: application/json');
  echo json_encode($data);
}

if (isset($_GET['customer_area'])) {
  $customer_distribution = query("SELECT pv.provinsi, COUNT(p.id) AS total_pembeli
                                FROM penjualan p
                                LEFT JOIN mahasiswa m ON p.mahasiswa_id = m.id
                                LEFT JOIN provinces pv ON m.provinsi_id = pv.id
                                GROUP BY pv.provinsi
                                ORDER BY total_pembeli DESC");

  header('Content-Type: application/json');
  echo json_encode($customer_distribution);
}
