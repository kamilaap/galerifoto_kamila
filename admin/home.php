<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login')  {
  echo "<script>
  alert('Anda belum Login!');
  location.href='../index.php';
  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
    body {
        background-color: #d6bd98; /* Beige background */
    }
    .navbar {
        background-color: #1a3636; /* Dark greenish-blue for navbar */
    }
    .navbar-brand, .navbar-nav .nav-link {
        color: #d6bd98; /* Beige text color for navbar */
    }
    .navbar-brand:hover, .navbar-nav .nav-link:hover {
        color: #ffffff; /* White color on hover */
    }
    .btn-outline-danger {
    border-color: #d6bd98; /* Warna border tombol logout */
    color: #d6bd98; /* Warna teks tombol logout */
  }

  .btn-outline-danger:hover {
    background-color: #d6bd98; /* Warna latar belakang tombol logout saat hover */
    color: #1a3636; /* Warna teks tombol logout saat hover */
  }
    .card {
        border: 1px solid #1a3636; /* Border color of the card */
    }
    .card-footer {
        background-color: #40534c; /* Dark greenish color for card footer */
    }
    footer {
        background-color: #1a3636; /* Footer background color */
        color: #d6bd98; /* Footer text color */
    }
    .fa-heart, .fa-thumbs-down, .fa-comment {
        color: #677d6a; /* Light green for icons */
    }
    .card-img-top {
        width: 100%; /* Make image width 100% to fit container */
        height: auto; /* Auto height to maintain aspect ratio */
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

<div class="container mt-3">
    <h5>Album:</h5>
    <?php
    $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
    while($row = mysqli_fetch_array($album)){ ?>
        <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="bg-warning btn btn-outline"><?php echo $row['namaalbum'] ?></a>
    <?php } ?>

    <div class="row">
      <?php
      if (isset($_GET['albumid'])) {
        $albumid = $_GET['albumid'];
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
        while($data = mysqli_fetch_array($query)){ ?>
          <div class="col-md-3 mt-2">
              <div class="card">
                  <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                  <div class="card-footer text-center">
                      <?php
                      $fotoid = $data['fotoid'];
                      $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                      if (mysqli_num_rows($ceksuka) == 1) { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
                      <?php } else { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                      <?php }
                      $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                      echo mysqli_num_rows($like). ' Suka';
                      ?>
                      <a href="#"><i class="fa-regular fa-comment"></i></a> 3 Komentar
                  </div>
              </div>
          </div>
        <?php } } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
        while($data = mysqli_fetch_array($query)) { ?>
          <div class="col-md-3 mt-2">
              <div class="card">
                  <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                  <div class="card-footer text-center">
                    <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    $cekbatalsuka = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-heart m-1"></i></a>
                    <?php } else { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-heart m-1"></i></a>
                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like) . ' Suka';
                    ?>
                    <?php
                    if (mysqli_num_rows($cekbatalsuka) == 1) { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-down m-1"></i></a>
                    <?php } else { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-down m-1"></i></a>
                    <?php }
                    $unlike = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($unlike) . ' ';
                    ?>
                    <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i></a>
                    <?php
                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($jmlkomen) . ' Komentar';
                    ?>
                  </div>
              </div>
          </div>
        <?php } } ?>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 fixed-bottom">
  <p>&copy; Web Galeri Foto | Kamila Putri Herlambang</p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js
"></script>
</body>
</html>