<?php
require 'function.php';
// Mengatur header untuk file CSV
header('Content-Type: text/csv');
$filename = 'datakeluar_' . date('Y-m-d') . '.csv';
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Membuat file pointer ke output
$output = fopen('php://output', 'w');

// Menulis header kolom
fputcsv($output, ['No', 'Nama Barang', 'Penerima', 'Stock', 'Tanggal']);

// Query data dari database
$query = mysqli_query($conn, "SELECT * FROM keluar, stock where stock.idbarang = keluar.idbarang and keluar.notification = 0") or die(mysqli_error($conn));
$rowNumber = 1;
while ($fetch = mysqli_fetch_array($query)) {
    fputcsv($output, [$rowNumber, $fetch['namabarang'], $fetch['penerima'], $fetch['qty'], $fetch['tanggal']]);
    $rowNumber++; // Increment nomor baris
}

// Menutup file pointer
fclose($output);
exit;
?>