<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//  Membuat Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if(isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $deleted = isset($_POST['deleted']) ? $_POST['deleted'] : 0;

    $addtostock = mysqli_query($conn, "INSERT into stock (namabarang, deskripsi, stock, deleted) values ('$namabarang', '$deskripsi', '$stock', '$deleted')");

    if($addtostock){
        header('location:stock.php');
    } else {
        echo 'gagal om';
        header('location:stock.php');
    }
}

// Barang Masuk
if(isset($_POST['masukinbarang'])) {
    $barangnya = $_POST['barangnya'];
    $pengirim = $_POST['pengirim'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahstocksekarangdenganqty = $stocksekarang + $qty;
        
    $addtomasuk = mysqli_query($conn, "INSERT into masuk (idbarang, pengirim, qty, notification) values ('$barangnya', '$pengirim', '$qty', '0')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$tambahstocksekarangdenganqty' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:barangmasuk.php');
    } else {
        echo 'gagal om';
        header('location:barangmasuk.php');
    }
};

// Barang Keluar
if (isset($_POST['barangmetu'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    // Mengecek stok saat ini
    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    if ($ambildatanya) {
        $stocksekarang = $ambildatanya['stock'];
        $tambahstocksekarangdenganqty = $stocksekarang - $qty;

        // Mengecek apakah stok mencukupi
        if ($tambahstocksekarangdenganqty >= 0) {
            // Menggunakan prepared statement untuk menghindari SQL Injection
            $masukkekeluar = $conn->prepare("INSERT INTO keluar (idbarang, penerima, qty, notification) VALUES (?, ?, ?, 0)");
            $masukkekeluar->bind_param("isi", $barangnya, $penerima, $qty);

            $updatestocknya = $conn->prepare("UPDATE stock SET stock=? WHERE idbarang=?");
            $updatestocknya->bind_param("ii", $tambahstocksekarangdenganqty, $barangnya);

            if ($masukkekeluar->execute() && $updatestocknya->execute()) {
                // Redirect hanya jika berhasil
                header('Location: barangkeluar.php');
                exit();
            } else {
                $_SESSION['error_message'] = 'Terjadi kesalahan, silakan coba lagi.';
            }

            
        } else {
            $_SESSION['error_message'] = 'Stok barang tidak mencukupi';
        }
    } else {
        $_SESSION['error_message'] = 'Data barang tidak ditemukan';
    }
        // Redirect kembali ke form untuk menampilkan pesan error
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

        $masukkekeluar->close();
        $updatestocknya->close();
}

// Barang Keluar Edit
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $namabarang = $_POST['namabarang'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['quantity'];

    // Ambil data stok barang
    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    if (!$lihatstock) {
        die('Error: ' . mysqli_error($conn));
    }
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    // Ambil data qty keluar
    $qtyskrng = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    if (!$qtyskrng) {
        die('Error: ' . mysqli_error($conn));
    }
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    // Hitung stok baru
    $stockbaru = $stocksekarang + $qtyskrng - $qty;

    // Validasi quantity
    if (empty($qty) || !is_numeric($qty)) {
        $qty = 0;
    }

    // Periksa apakah stok mencukupi
    if ($stockbaru < 0) {
        $_SESSION['error_message'] = 'Stok barang tidak mencukupi.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Update data stock
    $updateStock = $conn->prepare("UPDATE stock SET namabarang = ?, stock = ? WHERE idbarang = ?");
    if (!$updateStock) {
        die('Error preparing statement: ' . $conn->error);
    }
    $updateStock->bind_param("sii", $namabarang, $stockbaru, $idb);

    // Update data keluar
    $updateKeluar = $conn->prepare("UPDATE keluar SET qty = ?, penerima = ? WHERE idkeluar = ?");
    if (!$updateKeluar) {
        die('Error preparing statement: ' . $conn->error);
    }
    $updateKeluar->bind_param("isi", $qty, $penerima, $idk);

    // Eksekusi query update
    if ($updateStock->execute() && $updateKeluar->execute()) {
        header('Location: barangkeluar.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Gagal memperbarui data, silakan coba lagi.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit(); 
    }

    $updateStock->close();
    $updateKeluar->close();
}



// update stock
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    if (empty($stock) || !is_numeric($stock)) {
        $stock = 0;
    }

    $update = $conn->prepare("UPDATE stock SET namabarang = ?, deskripsi = ?, stock = ? WHERE idbarang = ?");
    $update->bind_param("ssii", $namabarang, $deskripsi, $stock, $idb);

    if ($update->execute()) {
        header('Location: stock.php');
        exit(); 
    } else {
        echo 'Gagal memperbarui data';
        header('Location: stock.php');
        exit(); 
    }

    $update->close();
}

// hapus barang stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $updatebarang = mysqli_query($conn, "UPDATE stock SET deleted = 1 WHERE idbarang='$idb'");
    if($updatebarang){
        header('Location: stock.php');
        exit();
    } else {
        echo 'Gagal menghapus data';
        header('Location: stock.php');
        exit();
    }
}

// restore barang
if(isset($_POST['restorebarang'])){
    $idb = $_POST['idb'];

    $restorebarang = mysqli_query($conn, "UPDATE stock SET deleted = 0 WHERE idbarang='$idb'");

    if($restorebarang){
        header('Location: history.php');
        exit();
    } else {
        echo 'Gagal mengembalikan barang';
        header('Location: history.php');
        exit();
    }
}

// Barang Masuk Edit
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $namabarang = $_POST['namabarang'];
    $pengirim = $_POST['pengirim'];
    $qty = $_POST['quantity'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    $stockbaru = $stocksekarang - $qtyskrng + $qty;

    if (empty($qty) || !is_numeric($qty)) {
        $qty = 0;
    }

    $updateStock = $conn->prepare("UPDATE stock SET namabarang = ?, stock = ? WHERE idbarang = ?");
    $updateStock->bind_param("sii", $namabarang, $stockbaru, $idb);

    $updateMasuk = $conn->prepare("UPDATE masuk SET qty = ?, pengirim = ? WHERE idmasuk = ?");
    $updateMasuk->bind_param("isi", $qty, $pengirim, $idm);

    if ($updateStock->execute() && $updateMasuk->execute()) {
        header('Location: barangmasuk.php');
        exit();
    } else {
        echo 'Gagal memperbarui data';
        header('Location: barangmasuk.php');
        exit();
    }

    $updateStock->close();
    $updateMasuk->close();
}

// Barang Masuk Delete
if (isset($_POST['deletebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    $stockbaru = $stocksekarang - $qtyskrng;

    $updateStock = $conn->prepare("UPDATE stock SET stock = ? WHERE idbarang = ?");
    $updateStock->bind_param("ii", $stockbaru, $idb);

    $updateNotification = $conn->prepare("UPDATE masuk SET notification = 1 WHERE idmasuk = ?");
    $updateNotification->bind_param("i", $idm);

    if ($updateStock->execute() && $updateNotification->execute()) {
        header('Location: barangmasuk.php');
        exit();
    } else {
        echo 'Gagal memperbarui notifikasi dan stok';
        header('Location: barangmasuk.php');
        exit();
    }

    // Close the statements
    $updateStock->close();
    $updateNotification->close();
}




// Delete Barang Keluar
if (isset($_POST['deletebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    $stockbaru = $stocksekarang + $qtyskrng;

    $updateStock = $conn->prepare("UPDATE stock SET stock = ? WHERE idbarang = ?");
    $updateStock->bind_param("ii", $stockbaru, $idb);

    $updateKeluar = $conn->prepare("UPDATE keluar SET notification = 1 WHERE idkeluar = ?");
    $updateKeluar->bind_param("i", $idk);

    if ($updateStock->execute() && $updateKeluar->execute()) {
        header('Location: barangkeluar.php');
        exit();
    } else {
        echo 'Gagal menghapus data';
        header('Location: barangkeluar.php');
        exit();
    }

    $updateStock->close();
    $updateKeluar->close();
}

?>