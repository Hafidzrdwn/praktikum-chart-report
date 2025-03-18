<?php

$conn = mysqli_connect('localhost', 'root', 'admin', 'koleksi_buku');

if (!$conn) {
  die("Database connection failed");
}
