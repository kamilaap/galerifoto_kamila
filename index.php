<?php
session_start();
include 'config/koneksi.php';

// Ambil data foto dari database
$query = "
    SELECT f.*, 
           COUNT(lf.likeid) AS jumlahsuka, 
           COUNT(uf.unlikefotoid) AS jumlahtidaksuka,
           COUNT(k.komentarid) AS jumlahkomentar 
    FROM foto f 
    LEFT JOIN likefoto lf ON f.fotoid = lf.fotoid 
    LEFT JOIN unlikefoto uf ON f.fotoid = uf.fotoid
    LEFT JOIN komentarfoto k ON f.fotoid = k.fotoid 
    GROUP BY f.fotoid
";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body {
            background-color: #d6bd98; /* Background color */
        }
        .box {
            width: 100%;
            height: 100vh;
            background-position: center;
            background-size: cover;
        }
        .card {
            background-color: #ffffff; /* Background color for cards */
        }
        .card-footer {
            background-color: #677d6a; /* Card footer color */
        }
        .navbar {
            background-color: #1a3636; /* Navbar color */
        }
        footer {
            background-color: #1a3636;
            color: #d6bd98;
             /* Footer color */
        }
        .btn-outline-primary {
            color: #d6bd98;
            border-color: #d6bd98;
        }
        .btn-outline-primary:hover {
            background-color: #d6bd98;
            color: #1a3636;
        }
        .btn-outline-success {
            color: #677d6a;
            border-color: #677d6a;
        }
        .btn-outline-success:hover {
            background-color: #677d6a;
            color: #ffffff;
        }
        .navbar-brand, .nav-link {
            color: #d6bd98;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffffff;
        }
        .card-img-top {
            width: 100%;
            height: 200px; /* Tetapkan tinggi yang konsisten untuk semua foto */
            object-fit: cover; /* Memastikan gambar memenuhi ruang tanpa mengubah aspek rasio */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-2" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <!-- Add your navigation links here -->
        </ul>
        <a href="register.php" class="btn btn-outline-primary m-1">Daftar</a>
        <a href="login.php" class="btn btn-outline-success m-1">Masuk</a>
      </div>
    </div>
</nav>
<div class="container mt-3">
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="assets/img/<?php echo $row['lokasifile']; ?>" class="card-img-top" title="<?php echo $row['judulfoto']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['judulfoto']; ?></h5>
                        <p class="card-text"><?php echo $row['deskripsifoto']; ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <span><?php echo $row['jumlahsuka']; ?> Suka</span> | 
                        <span><?php echo $row['jumlahtidaksuka']; ?> Tidak Suka</span> | 
                        <span><?php echo $row['jumlahkomentar']; ?> Komentar</span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<footer class="d-flex justify-content-center border-top mt-3 bg-#d6bd98 fixed-bottom">
    <p>&copy; Web Galeri Foto | Kamila Putri Herlambang</p>
</footer>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
