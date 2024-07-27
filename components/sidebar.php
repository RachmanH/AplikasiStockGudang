<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2c3e50;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-code-branch"></i>
                </div>
                <div class="sidebar-brand-text mx-2">Admin Gudang</div>
            </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php if (canAccessPage('index.php', $userRole)): ?>
    <li class="nav-item <?php echo $pageRequested == 'index.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt" ></i>
            <span>Dashboard</span></a>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Stock -->
    <?php if (canAccessPage('stock.php', $userRole)): ?>
    <li class="nav-item <?php echo $pageRequested == 'stock.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="stock.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Stock Barang</span></a>
    </li>
    <?php endif; ?>

    <!-- Nav Item - Barang Masuk -->
    <?php if (canAccessPage('barangmasuk.php', $userRole)): ?>
    <li class="nav-item <?php echo $pageRequested == 'barangmasuk.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="barangmasuk.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Barang Masuk</span></a>
    </li>
    <?php endif; ?>

    <!-- Nav Item - Barang Keluar -->
    <?php if (canAccessPage('barangkeluar.php', $userRole)): ?>
    <li class="nav-item <?php echo $pageRequested == 'barangkeluar.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="barangkeluar.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Barang Keluar</span></a>
    </li>
    <?php endif; ?>

    <!-- Nav Item - History Barang -->
    <?php if (canAccessPage('history.php', $userRole)): ?>
    <li class="nav-item <?php echo $pageRequested == 'history.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="history.php">
            <i class="fas fa-history"></i>
            <span>History Barang</span></a>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->