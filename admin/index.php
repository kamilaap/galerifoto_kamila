<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
  echo "<script>
  alert('Anda belum Login!');
  location.href='../index.php';
  </script>";
}
$userid = $_SESSION['userid'];
$query = mysqli_query($koneksi, "SELECT foto_profil, namalengkap FROM user WHERE userid='$userid'");
if ($query) {
    $user = mysqli_fetch_assoc($query);
} else {
    $user = array(); 
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
</head>
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

    .card {
        border: 1px solid #1a3636; /* Border color of the card */
    }
    .card-footer {
        background-color: #40534c; /* Dark greenish color for card footer */
    }
    .btn-outline-danger {
        color: #d6bd98;
        border-color: #d6bd98;
    }
    .btn-outline-danger:hover {
        background-color: #d6bd98;
        color: #1a3636;
    }
    .btn-outline-primary {
        color: #677d6a;
        border-color: #677d6a;
    }
    .btn-outline-primary:hover {
        background-color: #677d6a;
        color: #ffffff;
    }
    footer {
        background-color: #1a3636;
        color: #d6bd98;
        /* Footer color */
    }
    .modal-content {
        background-color: #ffffff; /* White background for modal */
    }
    .modal-header, .modal-footer {
        background-color: #1a3636; /* Dark greenish-blue for modal header and footer */
        color: #d6bd98; /* Beige text color in modal header and footer */
    }
    .modal-header .close {
        color: #d6bd98; /* Beige color for close button */
    }
    .input-group-prepend {
        background-color: #677d6a; /* Dark greenish color for input group prepend */
    }
    .a:hover {
        color: rgb(9,  175, 134); /* Modify this if necessary */
    }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1a3636;">
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
            <!-- Form Pencarian -->
            <form class="d-flex mx-auto" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari foto" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
        </div>
        <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
    </div>
</nav>

  <div class="container mt-2">
    <div class="container mt-4">
    <h1>Welcome, <?php echo isset($user['namalengkap']) ? $user['namalengkap'] : 'User'; ?>!</h1>
    <h3>Foto Terbaru</h3>
    <div class="row">
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($search)) {
        $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid WHERE judulfoto LIKE '%$search%'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid");
    }

    if (mysqli_num_rows($query) > 0) {
        while ($data = mysqli_fetch_array($query)) {
    ?>
        <!-- Kode untuk menampilkan foto -->
        <div class="col-md-3">
          <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>">
            <div class="card mb-2">
              <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 12rem; left:10px;">
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
          </a>
          <!-- Modal kode di sini -->
          <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-8">
                      <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                    </div>
                    <div class="col-md-4">
                      <div class="m-2">
                        <div class="overflow-auto">
                          <div class="sticky-top">
                            <a href="../assets/img/<?php echo $data['lokasifile'] ?>" download="Download">
                              <i class="fa-solid fa-download fa-xl"></i></a></br>
                            <strong><?php echo $data['judulfoto'] ?></strong><br>
                            <span class="badge bg-secondary"><?php echo $data['namalengkap'] ?></span>
                            <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                            <span class="badge bg-primary"><?php echo $data['namaalbum'] ?></span>
                          </div>
                          <hr>
                          <p align="left">
                            <?php echo $data['deskripsifoto'] ?>
                          </p>
                          <hr>
                          <?php
                          $fotoid = $data['fotoid'];
                          $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                          while ($row = mysqli_fetch_array($komentar)) {
                          ?>
                            <p align="left">
                              <strong><?php echo $row['namalengkap'] ?></strong>
                              <?php echo $row['isikomentar'] ?>
                            </p>
                          <?php } ?>
                          <hr>
                          <div class="sticky-bottom">
                            <form action="../config/proses_komentar.php" method="POST">
                              <div class="input-group">
                                <input type="hidden" name="fotoid" value="<?php echo $data['fotoid'] ?>">
                                <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                                <div class="input-group-prepend"></div>
                                <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <?php
        }
    } else {
        echo "<p>Foto tidak ditemukan.</p>";
    }
    ?>
    </div>
  </div>
<footer class="d-flex justify-content-center border-top mt-3 bg-#1a3636 fixed-bottom">
  <p>&copy; Web Galeri Foto | Kamila Putri Herlambang</p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
