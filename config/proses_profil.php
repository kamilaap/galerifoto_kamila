<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $hp = $_POST['hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $admin_id = $_POST['admin_id']; // Pastikan admin_id dikirimkan dalam form

    $update = mysqli_query($conn, "UPDATE tb_admin SET 
        admin_name = '$nama',
        username = '$user',
        admin_telp = '$hp',
        admin_email = '$email',
        admin_address = '$alamat'
        WHERE admin_id = '$admin_id'");

    if ($update) {
        echo '<script>alert("Ubah data berhasil")</script>';
        echo '<script>window.location="profil.php"</script>';
    } else {
        echo 'Gagal: '.mysqli_error($conn);
    }
}
?>
