<?php
session_start();
include 'koneksi.php';
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

// Cek apakah user sudah menyukai foto ini
$ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

if (mysqli_num_rows($ceksuka) == 1){
    // Jika sudah menyukai, hapus like
    while($row = mysqli_fetch_array($ceksuka)){
        $likeid = $row['likeid'];
        $query = mysqli_query($koneksi, "DELETE FROM likefoto WHERE likeid='$likeid'");

        echo "<script>
        location.href='../admin/home.php';
        </script>";
    }
} else {
    // Jika belum menyukai, tambahkan like
    $tanggallike = date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO likefoto (fotoid, userid, tanggallike) VALUES ('$fotoid', '$userid', '$tanggallike')");

    echo "<script>
    location.href='../admin/index.php';
    </script>";
}
?>
