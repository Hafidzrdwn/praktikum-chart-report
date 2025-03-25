<?php

require_once 'database.php';

define('BASEPATH', 'http://localhost:8080/praktikum/');

function login($data)
{
  global $conn;

  $username = $data["username"];
  $password = $data["password"];

  // cek apakah ada user dengan username yang diinputkan
  $query = "SELECT * FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 's', $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // cek username
  if (mysqli_num_rows($result) === 1) {

    // cek password
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
      // set session
      $_SESSION["login"] = true;
      $_SESSION["uname"] = $row["username"];
      $_SESSION["fname"] = $row["fullname"];

      return true;
    }
  }

  return false;
}

function registrasi($data)
{
  global $conn;

  $username = strtolower(stripslashes(htmlspecialchars($data["username"])));
  $fullname = strtolower(stripslashes(htmlspecialchars($data["fullname"])));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $confirmPass = mysqli_real_escape_string($conn, $data["password-confirm"]);

  // cek username sudah ada atau belum
  $query = "SELECT username FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 's', $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_fetch_assoc($result)) {
    echo "<script>
				
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Username sudah terdaftar!'
        });

		      </script>";
    return false;
  }

  // cek konfirmasi password
  if ($password !== $confirmPass) {
    echo "<script>
			
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Konfirmasi password tidak sesuai!'
        });

		      </script>";
    return false;
  }

  // cek apakah agree is checked
  if (!isset($data['agree'])) {
    echo "<script>
      
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Anda harus menyetujui syarat dan ketentuan!'
        });
          
            </script>";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // tambahkan userbaru ke database dengan bind parameter
  $query = "INSERT INTO users (username, fullname, password) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'sss', $username, $fullname, $password);
  mysqli_stmt_execute($stmt);

  return mysqli_affected_rows($conn);
}

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function querySingle($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_assoc($result);
}

function countData($table)
{
  global $conn;
  $query = "SELECT * FROM $table";
  $result = mysqli_query($conn, $query);
  return mysqli_num_rows($result);
}

function getSingleData($table, $column, $value)
{
  global $conn;
  $query = "SELECT * FROM $table WHERE $column = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 's', $value);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

function insertData($table, $data)
{
  global $conn;
  $columns = implode(", ", array_keys($data));
  $values = array_values($data);
  $values = array_map(function ($value) use ($conn) {
    return "'" . mysqli_real_escape_string($conn, $value) . "'";
  }, $values);
  $values = implode(", ", $values);
  $query = "INSERT INTO $table ($columns) VALUES ($values)";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function updateData($table, $data, $column, $value)
{
  global $conn;
  $set = [];
  foreach ($data as $key => $val) {
    $set[] = "$key = '" . mysqli_real_escape_string($conn, $val) . "'";
  }
  $set = implode(", ", $set);
  $query = "UPDATE $table SET $set WHERE $column = '$value'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function deleteData($table, $column, $value)
{
  global $conn;
  $query = "DELETE FROM $table WHERE $column = '$value'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function generateCode($table, $field, $char)
{
  global $conn;
  $query = "SELECT MAX($field) as max_code FROM $table";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $code = $row['max_code'] ?? '0';
  $no_urut = (int) substr($code, 3, 3);
  $no_urut++;
  $new_code = $char . sprintf("%03s", $no_urut) . '-' . date('ymdhis');
  return $new_code;
}

function toRupiah($angka)
{
  return "Rp" . number_format($angka, 0, ',', '.');
}

function rupiahToNumber($rupiah)
{
  return preg_replace('/\D/', '', $rupiah);
}
