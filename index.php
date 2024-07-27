<?php
require './function/function.php';
require './function/check.php';
require './function/auth.php';
// Cek apakah pengguna sudah login

?>
<?php
include './components/head.php';
?>
<head>
    <title>Dasbor</title>
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

     <!-- Sidebar -->
      <?php
      include './components/sidebar.php'
      ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #2b3036">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include './components/topbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-100">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <?php
                        // Ambil semua data keluar dari database
                        $query = "SELECT COUNT(*) AS jumlah_stock_barang FROM stock where deleted = 0;";
                        $hitungdata = mysqli_query($conn, $query);

                        // Ambil nilai hasil query
                        if ($hitungdata) {
                            $row = mysqli_fetch_assoc($hitungdata);
                            $jumlah_stock_barang = $row['jumlah_stock_barang'];
                        } else {
                            $jumlah_stock_barang = 'Error retrieving data'; // Handle error case jika query gagal
                        }
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 py-2 shadow-sm border-0" style="background-color: #383f48; border-radius: 10px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #BA55D3">
                                                Stock Barang</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-100"><?=$jumlah_stock_barang?> Barang</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <?php
                        // Ambil semua data keluar dari database
                        $query = "SELECT COUNT(*) AS jumlah_barang_masuk FROM masuk where notification = 0;";
                        $hitungdata = mysqli_query($conn, $query);

                        // Ambil nilai hasil query
                        if ($hitungdata) {
                            $row = mysqli_fetch_assoc($hitungdata);
                            $jumlah_barang_masuk = $row['jumlah_barang_masuk'];
                        } else {
                            $jumlah_barang_masuk = 'Error retrieving data'; // Handle error case jika query gagal
                        }
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 py-2 shadow-sm border-0" style="background-color: #383f48; border-radius: 10px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Barang Masuk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-100"><?= $jumlah_barang_masuk ?> Barang</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <?php
                        // Ambil semua data keluar dari database
                        $query = "SELECT COUNT(*) AS jumlah_barang_keluar FROM keluar where notification = 0;";
                        $hitungdata = mysqli_query($conn, $query);

                        // Ambil nilai hasil query
                        if ($hitungdata) {
                            $row = mysqli_fetch_assoc($hitungdata);
                            $jumlah_barang_keluar = $row['jumlah_barang_keluar'];
                        } else {
                            $jumlah_barang_keluar = 'Error retrieving data'; // Handle error case jika query gagal
                        }
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 py-2 shadow-sm border-0" style="background-color: #383f48; border-radius: 10px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Barang Keluar
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-100"><?=$jumlah_barang_keluar?> Barang</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <?php
                        // Ambil semua data keluar dari database
                        $query = "SELECT COUNT(*) AS jumlah_stock_barang FROM stock where deleted = 1;";
                        $hitungdata = mysqli_query($conn, $query);

                        // Ambil nilai hasil query
                        if ($hitungdata) {
                            $row = mysqli_fetch_assoc($hitungdata);
                            $jumlah_stock_barang = $row['jumlah_stock_barang'];
                        } else {
                            $jumlah_stock_barang = 'Error retrieving data'; // Handle error case jika query gagal
                        }
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 py-2 shadow-sm border-0" style="background-color: #383f48; border-radius: 10px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                History Barang</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-100"><?=$jumlah_stock_barang?> Barang</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-history fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 text-white mb-4"></h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users Online</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Uptime</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                             
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Kamu yakin akan Keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" name="logout" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include './components/footer.php';
    ?>

</body>

</html>