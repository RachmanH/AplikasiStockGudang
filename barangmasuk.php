<?php
require './function/function.php';
require './function/check.php';
require './function/auth.php';

// Pastikan user role sudah terdefinisi
$userRole = $_SESSION['role'] ?? '';

// Fungsi untuk memeriksa akses halaman
function canAccessFeature($userRole, $feature) {
    $featureAccess = [
        'tambah_barang' => ['admin', 'karyawan_barang_masuk'],
        'action' => ['admin', 'karyawan_barang_masuk'],
        'edit' => ['admin', 'karyawan_barang_masuk'],
    ];

    return in_array($userRole, $featureAccess[$feature] ?? []);
}
?>

<?php
include './components/head.php';
?>
<head>
    <title>Barang Masuk</title>
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
                        <h1 class="h3 mb-0 text-gray-100">Barang Masuk</h1>
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
                                $filename = 'datamasuk_' . date('Y-m-d') . '.csv';
                                ?>
                                <div><?php echo $filename; ?></div>
                            </div>                       
                                                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <form action="./function/export_barangmasuk.php">
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
                        <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Barang</th>
                                            <th>Quantity</th>
                                            <th>Pengirim</th>
                                            <?php if (canAccessFeature($userRole, 'action')): ?>
                                            <th>Action</th>  
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ambilsemuadatamasuk = mysqli_query($conn, "SELECT * FROM masuk, stock where stock.idbarang = masuk.idbarang and masuk.notification = 0");
                                    while ($data = mysqli_fetch_array($ambilsemuadatamasuk)) {
                                        $idb = $data['idbarang'];
                                        $idm = $data['idmasuk'];
                                        $tanggal = $data['tanggal'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $pengirim = $data['pengirim'];
                                    ?>
                                        <tr>
                                            <td><?= $tanggal ?></td>
                                            <td><?= $namabarang ?></td>
                                            <td><?= $qty ?></td>
                                            <td><?= $pengirim ?></td>
                                            <?php if (canAccessFeature($userRole, 'edit')): ?>
                                            <td class="d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#editModal<?=$idb?>">
                                                Edit
                                            </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?=$idb?>">
                                                    Delete
                                                </button>
                                            </td>
                                            <?php endif; ?>
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
                                                            <input type="text" name="pengirim" value="<?=$pengirim?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="quantity" value="<?=$qty?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?=$idb?>">
                                                            <input type="hidden" name="idm" value="<?=$idm?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Update</button>
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
                                                            <input type="hidden" name="idm" value="<?=$idm?>">
                                                            <button type="submit" class="btn btn-danger" name="deletebarangmasuk">Delete</button>
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
    
    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="POST">
            <div class="modal-body">
                <select name="barangnya" class="form-control" required>
                    <?php
                        $ambilsemuadata = mysqli_query($conn, "SELECT * FROM stock where deleted = 0");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                            echo "<option value='$idbarangnya'>$namabarangnya</option>";
                        }
                    ?>
                </select>
                <br>
                <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
                <br>
                <input type="text" name="pengirim" placeholder="Pengirim" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="masukinbarang">Submit</button>
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
