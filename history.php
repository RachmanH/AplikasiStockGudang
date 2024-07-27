<?php
require './function/function.php';
require './function/check.php';
require './function/auth.php';
    
?>

<?php
include './components/head.php';
?>
<head>
    <title>History Barang</title>
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
                        <h1 class="h3 mb-0 text-gray-100">Stock Barang</h1>
                       <button name="savek" class="d-none d-sm-inline-block btn shadow-sm text-white" data-toggle="modal" data-target="#ModalUnduh" style="background-color: #483d8b"><i
                                class="fas fa-download fa-sm text-white"></i> Generate Report</button> 
                    </div>

                    <!-- Modal Unduh -->
                    <div class="modal fade" id="ModalUnduh">
                    <div class="modal-dialog">
                    <div class="modal-content">
                                                
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Unduh</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                                                    
                            <!-- Modal body -->
                            <div class="modal-body text-center">
                                <div class="mb-2">
                                    <i class="fas fa-file-excel fa-3x"></i>
                                </div>
                                <?php
                                // Menggunakan PHP untuk mendefinisikan nama file CSV
                                $filename = 'history' . date('Y-m-d') . '.csv';
                                ?>
                                <div><?php echo $filename; ?></div>
                            </div>                       
                                                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <form action="./function/export_history.php">
                                    <button type="submit" class="btn text-gray-200" style="background-color: #483d8b">Unduh</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                                                    
                            </div>
                         </div>
                    </div> 


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php
    $ambilsemuadatastockuar = mysqli_query($conn, "SELECT * FROM stock WHERE deleted = 1");
    $i = 1; // Initialize counter outside of the loop
    while ($data = mysqli_fetch_assoc($ambilsemuadatastockuar)) {
        $namabarang = $data['namabarang'];
        $deskripsi = $data['deskripsi'];
        $stock = $data['stock'];
        $idb = $data['idbarang'];
    ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $namabarang ?></td>
            <td><?= $deskripsi ?></td>
            <td><?= $stock ?></td>
            <td class="d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?=$idb?>">
                Restore
                </button>
            </td>
        </tr>

        <!-- Modal Restore -->
        <div class="modal fade" id="editModal<?=$idb?>">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Restore Item</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="idb" value="<?= $data['idbarang'] ?>">
                            <p>Are you sure you want to restore this item?</p>
                        </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="restorebarang">Restore</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    };
    ?>
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

      </div>
    </div>
  </div>
</div>



</body>

</html>