<?php
require './function/function.php';
require './function/check.php';
require './function/auth.php';

// Pastikan user role sudah terdefinisi
$userRole = $_SESSION['role'] ?? '';

// Fungsi untuk memeriksa akses halaman
function canAccessFeature($userRole, $feature) {
    $featureAccess = [
        'tambah_barang' => ['admin', 'karyawan_stock_barang'],
        'action' => ['admin', 'karyawan_stock_barang'],
        'edit' => ['admin', 'karyawan_stock_barang'],
    ];

    return in_array($userRole, $featureAccess[$feature] ?? []);
}
?>

<?php
include './components/head.php';
?>
<head>
    <title>Stock Barang</title>
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
                                $filename = 'stockbarang' . date('Y-m-d') . '.csv';
                                ?>
                                <div><?php echo $filename; ?></div>
                            </div>                       
                                                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <form action="./function/export_stock.php">
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
                        <?php if (canAccessFeature($userRole, 'tambah_barang')): ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Tambah Barang
                        </button>
                        <?php endif ?>
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
                                            <?php if (canAccessFeature($userRole, 'action')): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ambilsemuadatastockuar = mysqli_query($conn, "SELECT * FROM stock WHERE deleted = 0");
                                    $i = 1; // Initialize counter outside of the loop
                                    while ($data = mysqli_fetch_array($ambilsemuadatastockuar)) {
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
                                            <?php if (canAccessFeature($userRole, 'edit')): ?>
                                            <td class="d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#editModal<?=$idb?>">
                                                Edit
                                            </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?=$idb?>">
                                                    Delete
                                                </button>
                                            </td>
                                            <?php endif ?>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal<?=$idb?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Item</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="text" name="namabarang" value="<?=$namabarang?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="deskripsi" value="<?=$deskripsi?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="stock" value="<?=$stock?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?=$idb?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Update</button>
                                                        </div>
                                                    </form>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteModal<?=$idb?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Apakah Kamu Yakin Akan Menghapusnya???
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <form method="POST">
                                                            <input type="hidden" name="idb" value="<?=$idb?>">
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                    
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

    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
         <form method="POST">
        <div class="modal-body">
          <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
          <br>
          <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
          <br>
          <input type="number" name="stock" class="form-control" placeholder="Stock" required> 
          <br>
          <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
        </div>
        </form>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</div>



</body>

</html>
