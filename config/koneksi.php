<?php
$hostname = 'localhost';
$userdb = 'root';
$passdb = '';
$namedb = 'ukk_galerifoto';

$koneksi = mysqli_connect($hostname,$userdb,$passdb,$namedb);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>