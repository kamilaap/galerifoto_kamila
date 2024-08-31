<?php 
session_start();
include 'koneksi.php';

if(isset($_POST['tambah'])){
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['albumid'];
    $userid = $_SESSION['userid'];
    $foto = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand() . '-' . $foto;

    if(move_uploaded_file($tmp, $lokasi . $namafoto)){
        $sql = mysqli_query($koneksi,"INSERT INTO foto (judulfoto, deskripsifoto, tanggalunggah, albumid, userid, lokasifile) 
        VALUES ('$judulfoto', '$deskripsifoto', '$tanggalunggah', '$albumid', '$userid', '$namafoto')");

        echo "<script>
        alert('Data berhasil disimpan!');
        location.href='../admin/foto.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal mengunggah foto.');
        location.href='../admin/foto.php';
        </script>";
    }
}

if(isset($_POST['edit'])){
    $fotoid = $_POST['fotoid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['albumid'];
    $userid = $_SESSION['userid'];
    $foto = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand() . '-' . $foto;

    if($foto == null){
        $sql = mysqli_query($koneksi,"UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', albumid='$albumid' WHERE fotoid='$fotoid'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
        $data = mysqli_fetch_array($query);
        if(is_file('../assets/img/' . $data['lokasifile'])){
            unlink('../assets/img/' . $data['lokasifile']);
        }
        if(move_uploaded_file($tmp, $lokasi . $namafoto)){
            $sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', lokasifile='$namafoto', albumid='$albumid' WHERE fotoid='$fotoid'");
        }
    }

    echo "<script>
    alert('Data berhasil diperbaharui!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['hapus'])) {
    $fotoid = $_POST['fotoid'];
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
    $data = mysqli_fetch_array($query);
    if(is_file('../assets/img/' . $data['lokasifile'])){
        unlink('../assets/img/' . $data['lokasifile']);
    }
    $sql = mysqli_query($koneksi, "DELETE FROM foto WHERE fotoid='$fotoid'");

    echo "<script>
    alert('Data berhasil dihapus!');
    location.href='../admin/foto.php';
    </script>";
}
?>
