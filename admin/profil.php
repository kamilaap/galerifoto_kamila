<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';

// Cek status login
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit();
}

// Ambil data pengguna dari database

$userid = $_SESSION['userid'];
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE userid='$userid'");
$data = mysqli_fetch_assoc($query);

// Proses penghapusan akun dan perubahan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ubah'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $namalengkap = $_POST['namalengkap'];

        $update = mysqli_query($koneksi, "UPDATE user SET 
            username = '$username',
            email = '$email',
            namalengkap = '$namalengkap'
            WHERE userid = '$userid'");

        if ($update) {
            echo '<script>alert("Ubah data berhasil")</script>';
            echo '<script>window.location="profil.php"</script>';
        } else {
            echo 'Gagal: '.mysqli_error($koneksi);
        }
    } elseif (isset($_POST['ubah_password'])) {
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];

        if ($pass2 != $pass1) {
            echo '<script>alert("Konfirmasi Password Baru tidak sesuai")</script>';
        } else {
            $u_pass = mysqli_query($koneksi, "UPDATE user SET 
                password = '".md5($pass1)."'
                WHERE userid = '$userid'");

            if ($u_pass) {
                echo '<script>alert("Ubah password berhasil")</script>';
                echo '<script>window.location="profil.php"</script>';
            } else {
                echo 'Gagal: '.mysqli_error($koneksi);
            }
        }
        if (isset($_POST['ubah_foto'])) {
          $nama_foto = $_FILES['foto_profil']['name'];
          $tmp_name = $_FILES['foto_profil']['tmp_name'];
          $error = $_FILES['foto_profil']['error'];
          $ukuran = $_FILES['foto_profil']['size'];
      
          $ekstensi = pathinfo($nama_foto, PATHINFO_EXTENSION);
          $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png', 'gif'];
      
          if ($error === 0) {
              if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
                  if ($ukuran <= 5000000) { // 5MB max
                      $nama_foto_baru = uniqid('', true) . "." . $ekstensi;
                      $upload_dir = 'C:/laragon/www/galerifoto_kamila/uploads/profil/';
      
                      if (!is_dir($upload_dir)) {
                          mkdir($upload_dir, 0755, true);
                      }
      
                      if (move_uploaded_file($tmp_name, $upload_dir . $nama_foto_baru)) {
                          $update_foto = mysqli_query($koneksi, "UPDATE user SET foto_profil = '$nama_foto_baru' WHERE userid = '$userid'");
      
                          if ($update_foto) {
                              echo '<script>alert("Ubah foto profil berhasil")</script>';
                              echo '<script>window.location="profil.php"</script>';
                          } else {
                              echo 'Gagal: ' . mysqli_error($koneksi);
                          }
                      } else {
                          echo '<script>alert("Gagal mengunggah file")</script>';
                      }
                  } else {
                      echo '<script>alert("Ukuran file terlalu besar")</script>';
                  }
              } else {
                  echo '<script>alert("Ekstensi file tidak diperbolehkan")</script>';
              }
          } else {
              echo '<script>alert("Terjadi kesalahan saat mengunggah file")</script>';
          }
      }
      
    } elseif (isset($_POST['hapus'])) {
        // Hapus data dari tabel terkait
        mysqli_query($koneksi, "DELETE FROM user WHERE userid='$userid'");
        mysqli_query($koneksi, "DELETE FROM likefoto WHERE userid='$userid'");
        mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE userid='$userid'");

        // Hapus sesi dan redirect ke halaman login
        session_destroy();
        echo "<script>
        alert('Akun berhasil dihapus!');
        location.href='../index.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Galeri Foto</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <style>
    /* Add your styles here */
    @charset "utf-8";
    * {
      padding:0;
      margin:0;
      font-family: 'Quicksand', sans-serif;
    }
    body {
      background-color: #d6bd98; /* Beige background */
    }
    a {
      color: inherit;
      text-decoration: none;
    }
    #bg-login {
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }
    .box-login {
      width: 300px;
      min-height: 200px;
      border: 1px solid #ccc;
      background-color: #fff;
      padding: 15px;
      box-sizing: border-box;
    }
    .box-login h2 {
      text-align: center;
      margin-bottom: 15px;
    }
    .input-control {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      box-sizing: border-box;
    }
    .btn {
      padding: 8px 15px;
      background-color: #40534c; /* Dark greenish */
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #677d6a; /* Light greenish */
    }
    header {
      background-color: #1a3636; /* Dark greenish-blue */
      color: #fff;
    }
    header h1 {
      float: left;
      padding: 10px 0;
    }
    header ul {
      float: right;
    }
    header ul li {
      display: inline-block;
    }
    header ul li a {
      padding: 20px 0 20px 15px;
      display: inline-block;
      color: #d6bd98; /* Beige text color */
    }
    header ul li a:hover {
      color: #fff; /* White color on hover */
    }
    .navbar {
            background-color: #1a3636; /* Navbar color */
        }
        .navbar-brand, .nav-link {
            color: #d6bd98;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffffff;
        }
    .container {
      width: 80%;
      margin: 0 auto;
    }
    .container:after {
      content: '';
      display: block;
      clear: both;
    }
    .section {
      padding: 25px 0;
    }
    .box {
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 15px;
      box-sizing: border-box;
      margin: 10px 0 25px 0;
    }
    .box:after {
      content: '';
      display: block;
      clear: both;
    }
    .table {
      width: 100%;
      border-collapse: collapse;
    }
    .table tr {
      height: 30px;
    }
    .table tr td {
      padding: 5px 10px;
    }
    .search {
      padding: 15px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      text-align: center;
    }
    .search input[type=text] {
      width: 60%;
      padding: 10px;
    }
    .search input[type=submit] {
      padding: 12px 15px;
      background-color: #40534c; /* Dark greenish */
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .col-5 {
      width: 20%;
      height: 100px;
      text-align: center;
      float: left;
      padding: 10px;
      box-sizing: border-box;
    }
    .col-4 {
      width: 25%;
      height: 230px;
      border: 1px solid #ccc;
      float: left;
      padding: 10px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }
    .col-4:hover {
      box-shadow: 0 0 3px #999;
    }
    .col-4 img {
      width: 100%;
    }
    .col-4 .nama {
      font-weight: bold;
      color: #666;
      margin-bottom: 5px;
    }
    .col-4 .admin {
      font-weight: bold;
      color: #FC3F81;
    }
    footer {
            background-color: #1a3636;
            color: #d6bd98;
             /* Footer color */
        }
    .col-2 {
      width: 50%;
      min-height: 200px;
      padding: 10px;
      box-sizing: border-box;
      float: left;
    }
    .col-2 img {
      border: 1px solid #f9f9f9;
      padding: 5px;
      box-sizing: border-box;
    }
    .col-2 h3 {
      margin-bottom: 10px;
    }
    .col-2 h4 {
      color: #C70039;
    }
    .col-2 p {
      margin: 15px 0;
      text-align: justify;
      line-height: 25px;
      font-size: 14px;
    }
    @media screen and (max-width: 768px) {
      .container {
        width: 90%;
      }
      .col-5 {
        width: 50%;
        margin-bottom: 10px;
      }
      .col-4 {
        width: 50%;
        height: 300px;
      }
      .col-2 {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
          <a href="home.php" class="nav-link">Home</a>
          <a href="album.php" class="nav-link">Album</a>
          <a href="foto.php" class="nav-link">Foto</a>
          <a href="profil.php" class="nav-link">Profil</a>
        </div>
        <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
      </div>
    </div>
  </nav>

  <!-- content -->
  <div class="section">
    <div class="container">
      <h3>Profil</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="text" name="username" placeholder="Nama Pengguna" class="input-control" value="<?php echo $data['username']; ?>" required>
          <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $data['email']; ?>" required>
          <input type="text" name="namalengkap" placeholder="Nama Lengkap" class="input-control" value="<?php echo $data['namalengkap']; ?>" required>
          <input type="submit" name="ubah" value="Ubah Profil" class="btn">
        </form>
      </div>
      
      <h3>Ubah Password</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
          <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
          <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
        </form>
      </div>

      <h3>Ubah Foto Profil</h3>
      <div class="box">
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="file" name="foto_profil" class="input-control" required>
          <input type="submit" name="ubah_foto" value="Ubah Foto Profil" class="btn">
        </form>
      </div>

      <h3>Hapus Profil</h3>
      <div class="box">
        <form action="" method="POST">
          <input type="submit" name="hapus" value="Hapus Profil" class="btn btn-danger">
        </form>
      </div>
    </div>
  </div>

  <!-- footer -->
  <footer class="d-flex justify-content-center border-top mt-3 bg-#1a3636 fixed-bottom">
    <p>&copy; Web Galeri Foto | Kamila Putri Herlambang</p>
  </footer>
</body>
</html>
