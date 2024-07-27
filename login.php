<?php
session_start();
require './function/function.php';

// Jika pengguna sudah login, arahkan ke halaman sesuai peran
if (isset($_SESSION['log']) && $_SESSION['log'] === true) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: index.php');
        exit();
    } elseif ($_SESSION['role'] == 'karyawan_barang_masuk') {
        header('Location: barangmasuk.php');
        exit();
    } elseif ($_SESSION['role'] == 'karyawan_barang_keluar') {
        header('Location: barangkeluar.php');
        exit();
    } elseif ($_SESSION['role'] == 'karyawan_stock_barang') {
        header('Location: stock.php');
        exit();
    }
}

// Proses login
if (isset($_POST['login'])) {
    require './function/function.php'; // Pastikan koneksi database tersedia

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Mencocokkan data pada database
    $cekdatabase = mysqli_query($conn, "SELECT * FROM `login` WHERE email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);
    $role = mysqli_fetch_assoc($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = true;
        $_SESSION['role'] = $role['role'];

        if ($role['role'] == 'admin') {
            header('Location: index.php');
        } elseif ($role['role'] == 'karyawan_barang_masuk') {
            header('Location: barangmasuk.php');
        } elseif ($role['role'] == 'karyawan_barang_keluar') {
            header('Location: barangkeluar.php');
        } elseif ($role['role'] == 'karyawan_stock_barang') {
            header('Location: stock.php');
        }
        exit();
    } else {
        $_SESSION['login_error'] = true; // Atur variabel sesi jika login gagal
    }
}

// Memeriksa apakah ada kesalahan login
$login_error = false;
if (isset($_SESSION['login_error'])) {
    $login_error = true;
    unset($_SESSION['login_error']); // Menghapus variabel sesi untuk kesalahan login setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Page</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-color: #2c3e50;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5" style="background-color: #2b3036">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-white mb-4">Login Admin</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button name="login" class="btn btn-primary btn-user btn-block data-target="#myModal">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- jQuery, Popper.js, dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


     <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title text-center">Wrong Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Please Insert Correct Password
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>

<script>
// Tampilkan modal jika login_error adalah true
<?php if ($login_error): ?>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
<?php endif; ?>
</script>


</body>

</html>