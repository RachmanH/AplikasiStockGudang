<?php
// jika belum
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    header('Location: login.php');
    exit();
}
?>