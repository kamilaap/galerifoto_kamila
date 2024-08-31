<?php 
include'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];

$sql =  "INSERT INTO user (username, password, email, namalengkap, alamat)
VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat')";

if (mysqli_query($koneksi, $sql)) {
    echo "<script>
    alert('Pendaftaran akun berhasil');
    window.location.href='../login.php';
    </script>";
} else {
    echo "Error:" . $sql . "<br>" . mysqli_error($koneksi);
}
?> 