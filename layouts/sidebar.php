<!-- Sidebar -->
<?php

function is_active($path)
{
  $current_path = array_values(array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 3));
  if (count($current_path) > 1) $page = implode('/', $current_path);
  else $page = $current_path[0];

  return $page == $path ? 'active' : '';
}

?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= BASEPATH; ?>views/index.php">Pemrog Web</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?= BASEPATH; ?>views/index.php">PWeb</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="<?= is_active("index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/index.php"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="menu-header">Data Master</li>
      <li class="<?= is_active("data_users/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/data_users/index.php"><i class="fas fa-users"></i><span>Data Users</span></a>
      </li>
      <li class="<?= is_active("data_kategori_buku/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/data_kategori_buku/index.php"><i class="fas fa-book"></i><span>Data Kategori Buku</span></a>
      </li>
      <li class="<?= is_active("data_buku/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/data_buku/index.php"><i class="fas fa-book"></i><span>Data Buku</span></a>
      </li>
      <li class="<?= is_active("data_mahasiswa/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/data_mahasiswa/index.php"><i class="fas fa-user"></i><span>Data Mahasiswa</span></a>
      </li>

      <li class="menu-header">Transaksi</li>
      <li class="<?= is_active("penjualan/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/penjualan/index.php"><i class="fas fa-money-bill-wave-alt"></i><span>Penjualan</span></a>
      </li>
      <li class="<?= is_active("penjualan/rekap.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/penjualan/rekap.php"><i class="fas fa-chart-bar"></i><span>Rekap Transaksi</span></a>
      </li>
    </ul>
  </aside>
</div>