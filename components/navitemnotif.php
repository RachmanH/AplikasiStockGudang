<?php
// Ambil semua data masuk dari database
$query = "SELECT masuk.tanggal, stock.namabarang, masuk.qty, masuk.pengirim 
            FROM masuk 
            JOIN stock ON stock.idbarang = masuk.idbarang 
            ORDER BY masuk.tanggal DESC";
$ambilsemuadatamasuk = mysqli_query($conn, $query);
$data_masuk = mysqli_fetch_all($ambilsemuadatamasuk, MYSQLI_ASSOC);

// Ambil hanya tiga data pertama untuk ditampilkan secara terbatas
$data_masuk_terbatas = array_slice($data_masuk, 0, 3);
$data_masuk_more = $data_masuk;

// ID unik untuk panel notifikasi
$panel_id = 1;

// Cek apakah data masuk kosong
if (count($data_masuk) == 0) {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-envelope fa-fw'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>0</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Barang Masuk
                </h6>
                <a class='dropdown-item d-flex align-items-center' href='#' style='justify-content: center;'>
                    <div>
                        <span class='text-gray-600'>Belum ada barang</span>
                    </div>
                </a>
                <a class='dropdown-item text-center small text-gray-500' href='#'>Tampilkan Semua Pesan</a>
            </div>
          </li>";
} else {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-envelope fa-fw'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>" . count($data_masuk) . "</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Barang Masuk
                </h6>
                <div id='limited-notifications-$panel_id'>";

    foreach ($data_masuk_terbatas as $data) {
        echo "<a class='dropdown-item d-flex align-items-center limited-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-primary'>
                        <i class='fas fa-file-alt text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>
                    <span class='font-weight-bold'>" . $data['namabarang'] . "</span>
                    <div><span class='font-weight-medium'>To: " . $data['pengirim'] . "</span></div>
                    <div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-more-$panel_id' data-panel-id='$panel_id'>Tampilkan Semua Pesan</a>
          <div id='all-notifications-$panel_id' style='display: none; max-height: 500px; overflow-y: auto;'>";

    foreach ($data_masuk_more as $data) {
        echo "<a class='dropdown-item d-flex align-items-center all-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-primary'>
                        <i class='fas fa-file-alt text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>
                    <span class='font-weight-bold'>" . $data['namabarang'] . "</span>
                    <div><span class='font-weight-medium'>To: " . $data['pengirim'] . "</span></div>
                    <div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-less-$panel_id' data-panel-id='$panel_id' style='display: none;'>Show Less</a>
          </div>
          </li>";

    $panel_id++;
}
?>

<?php
// Ambil semua data keluar dari database
$query = "SELECT keluar.tanggal, stock.namabarang, keluar.qty, keluar.penerima 
            FROM keluar 
            JOIN stock ON stock.idbarang = keluar.idbarang 
            ORDER BY keluar.tanggal DESC";
$ambilsemuadatakeluar = mysqli_query($conn, $query);
$data_keluar = mysqli_fetch_all($ambilsemuadatakeluar, MYSQLI_ASSOC);

// Ambil hanya tiga data pertama untuk ditampilkan secara terbatas
$data_keluar_terbatas = array_slice($data_keluar, 0, 3);
$data_keluar_more = $data_keluar;

// ID unik untuk panel notifikasi
$panel_id = 2;

// Cek apakah data keluar kosong
if (count($data_keluar) == 0) {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-bell fa-fw'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>0</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Barang keluar
                </h6>
                <a class='dropdown-item d-flex align-items-center' href='#' style='justify-content: center;'>
                    <div>
                        <span class='text-gray-600'>Belum ada barang</span>
                    </div>
                </a>
                <a class='dropdown-item text-center small text-gray-500' href='#'>Tampilkan Semua Pesan</a>
            </div>
          </li>";
} else {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-bell fa-fw'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>" . count($data_keluar) . "</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Barang keluar
                </h6>
                <div id='limited-notifications-$panel_id'>";

    foreach ($data_keluar_terbatas as $data) {
        echo "<a class='dropdown-item d-flex align-items-center limited-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-primary'>
                        <i class='fas fa-file-alt text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>
                    <span class='font-weight-bold'>" . $data['namabarang'] . "</span>
                    <div><span class='font-weight-medium'>To: " . $data['penerima'] . "</span></div>
                    <div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-more-$panel_id'>Tampilkan Semua Pesan</a>
          <div id='all-notifications-$panel_id' style='display: none; max-height: 500px; overflow-y: auto;'>";

    foreach ($data_keluar_more as $data) {
        echo "<a class='dropdown-item d-flex align-items-center all-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-primary'>
                        <i class='fas fa-file-alt text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>
                    <span class='font-weight-bold'>" . $data['namabarang'] . "</span>
                    <div><span class='font-weight-medium'>To: " . $data['penerima'] . "</span></div>
                    <div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-less-$panel_id' style='display: none;'>Show Less</a>
          </div>
          </li>";

    $panel_id++;
}
?>

<?php
// Ambil semua data delete masuk dari database
$query_delete_masuk = "SELECT masuk.tanggal, stock.namabarang, masuk.qty, masuk.pengirim, masuk.notification, 'masuk' AS type
                        FROM masuk 
                        JOIN stock ON stock.idbarang = masuk.idbarang 
                        WHERE masuk.notification = 1
                        ORDER BY masuk.tanggal DESC";
$ambilsemuadatadeletemasuk = mysqli_query($conn, $query_delete_masuk);
$data_deletemasuk = mysqli_fetch_all($ambilsemuadatadeletemasuk, MYSQLI_ASSOC);

// Ambil semua data delete keluar dari database
$query_delete_keluar = "SELECT keluar.tanggal, stock.namabarang, keluar.qty, keluar.penerima, keluar.notification, 'keluar' AS type
                        FROM keluar 
                        JOIN stock ON stock.idbarang = keluar.idbarang 
                        WHERE keluar.notification = 1
                        ORDER BY keluar.tanggal DESC";
$ambilsemuadatadeletekeluar = mysqli_query($conn, $query_delete_keluar);
$data_deletekeluar = mysqli_fetch_all($ambilsemuadatadeletekeluar, MYSQLI_ASSOC);

// Gabungkan data delete masuk dan delete keluar
$data_delete = array_merge($data_deletemasuk, $data_deletekeluar);

// Urutkan berdasarkan tanggal
usort($data_delete, function($a, $b) {
    return strtotime($b['tanggal']) - strtotime($a['tanggal']);
});

// Ambil hanya tiga data pertama untuk ditampilkan secara terbatas
$data_delete_terbatas = array_slice($data_delete, 0, 3);
$data_delete_more = $data_delete;

// ID unik untuk panel notifikasi
$panel_id = 3;

// Cek apakah data delete kosong
if (count($data_delete) == 0) {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-trash'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>0</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Delete Barang
                </h6>
                <a class='dropdown-item d-flex align-items-center' href='#' style='justify-content: center;'>
                    <div>
                        <span class='text-gray-600'>Belum ada barang</span>
                    </div>
                </a>
                <a class='dropdown-item text-center small text-gray-500' href='#'>Tampilkan Semua Pesan</a>
            </div>
          </li>";
} else {
    echo "<li class='nav-item dropdown no-arrow mx-1'>
            <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown-$panel_id' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-trash'></i>
                <!-- Counter - Alerts -->
                <span class='badge badge-danger badge-counter'>" . count($data_delete) . "</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in' aria-labelledby='alertsDropdown-$panel_id'>
                <h6 class='dropdown-header'>
                    Pesan Delete Barang
                </h6>
                <div id='limited-notifications-$panel_id'>";

    foreach ($data_delete_terbatas as $data) {
        echo "<a class='dropdown-item d-flex align-items-center limited-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-danger'>
                        <i class='fas fa-trash text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>";
        if ($data['type'] == 'masuk') {
            echo "<span class='font-weight-bold'>Delete Masuk: " . $data['namabarang'] . "</span>
            <div><span class='font-weight-medium'>Dari: " . $data['pengirim'] . "</span></div>";
        } else {
            echo "<span class='font-weight-bold'>Delete Keluar: " . $data['namabarang'] . "</span>
            <div><span class='font-weight-medium'>Ke: " . $data['penerima'] . "</span></div>";
        }
        echo "<div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-more-$panel_id' data-panel-id='$panel_id'>Tampilkan Semua Pesan</a>
          <div id='all-notifications-$panel_id' style='display: none; max-height: 500px; overflow-y: auto;'>";

    foreach ($data_delete_more as $data) {
        echo "<a class='dropdown-item d-flex align-items-center all-notification' href='#'>
                <div class='mr-3'>
                    <div class='icon-circle bg-danger'>
                        <i class='fas fa-trash text-white'></i>
                    </div>
                </div>
                <div>
                    <div class='small text-gray'>" . date("j F Y H:i:s", strtotime($data['tanggal'])) . "</div>
                    ";
        if ($data['type'] == 'masuk') {
            echo "<span class='font-weight-bold'>Delete Masuk: " . $data['namabarang'] . "</span>
            <div><span class='font-weight-medium'>Dari: " . $data['pengirim'] . "</span></div>";
        } else {
            echo "<span class='font-weight-bold'>Delete Keluar: " . $data['namabarang'] . "</span>
            <div><span class='font-weight-medium'>Ke: " . $data['penerima'] . "</span></div>";
        }
        echo "<div><span class='font-weight-medium'>Total: " . $data['qty'] . " Barang</span></div>
                </div>
              </a>";
    }

    echo "</div>
          <a class='dropdown-item text-center small text-gray-700' href='#' id='toggle-show-less-$panel_id' data-panel-id='$panel_id' style='display: none;'>Show Less</a>
          </div>
          </li>";

    $panel_id++;
}
?>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loop through each panel
    var panels = document.querySelectorAll('[id^="toggle-show-more-"]');
    panels.forEach(function(panel) {
        var panelId = panel.id.split('-').pop();
        var toggleShowMore = document.getElementById('toggle-show-more-' + panelId);
        var toggleShowLess = document.getElementById('toggle-show-less-' + panelId);
        var allNotifications = document.getElementById('all-notifications-' + panelId);
        var limitedNotifications = document.getElementById('limited-notifications-' + panelId);

        toggleShowMore.addEventListener('click', function(event) {
            event.preventDefault();

            limitedNotifications.style.display = 'none';
            allNotifications.style.display = 'block';
            toggleShowMore.style.display = 'none';
            toggleShowLess.style.display = 'block';

            // Scroll to top of dropdown
            allNotifications.scrollTop = 0;

            // Prevent dropdown from closing
            event.stopPropagation();
        });

        toggleShowLess.addEventListener('click', function(event) {
            event.preventDefault();

            limitedNotifications.style.display = 'block';
            allNotifications.style.display = 'none';
            toggleShowMore.style.display = 'block';
            toggleShowLess.style.display = 'none';

            // Scroll to top of dropdown
            limitedNotifications.scrollTop = 0;

            // Prevent dropdown from closing
            event.stopPropagation();
        });

        // Prevent dropdown from closing when clicking inside it
        var dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
});
</script>