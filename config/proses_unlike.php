<?php
session_start();
include 'koneksi.php';
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");

if (mysqli_num_rows($ceksuka) == 1){
    while($row = mysqli_fetch_array($ceksuka)){
        $unlikefotoid = $row['unlikefotoid'];
        $query = mysqli_query($koneksi, "DELETE FROM unlikefoto WHERE unlikefotoid='$unlikefotoid'");

        echo "<script>
location.href='../admin/home.php';
</script>";
    }
}else{
    $tanggalunlike = date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO unlikefoto (fotoid, userid, tanggalunlike) VALUES ('$fotoid', '$userid', '$tanggalunlike')");

echo "<script>
location.href='../admin/index.php';
</script>";
}



?>