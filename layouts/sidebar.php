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
      <a href="<?= BASEPATH; ?>views/index.php">Koleksi Buku</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?= BASEPATH; ?>views/index.php">KB</a>
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
      <li class="<?= is_active("data_buku/index.php"); ?>">
        <a class="nav-link"
          href="<?= BASEPATH; ?>views/data_buku/index.php"><i class="fas fa-book"></i><span>Data Buku</span></a>
      </li>
    </ul>
  </aside>
</div>