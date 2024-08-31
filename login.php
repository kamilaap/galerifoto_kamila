<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #d6bd98; /* Light beige background color */
        }
        .navbar {
            background-color: #1a3636;
            color: #d6bd98;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #d6bd98; /* Light beige text color for navbar */
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #ffffff; /* White color on hover */
        }
        .btn-outline-primary {
            color: #d6bd98;
            border-color: #d6bd98;
        }
        .btn-outline-primary:hover {
            background-color: #d6bd98;
            color: #1a3636;
        }
        .btn-navbar {
            color: #d6bd98;
            border-color: #d6bd98;
        }
        .btn-navbar:hover {
            background-color: #d6bd98;
            color: #1a3636;
        }
        .card-body {
            background-color: #ffffff; /* White background for card body */
        }
        .card {
            border: 1px solid #1a3636; /* Border color of the card */
        }
        footer {
            background-color: #1a3636;
            color: #d6bd98; /* Footer color */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Navigation links here -->
            </ul>
            <a href="register.php" class="btn btn-outline-primary m-1">Daftar</a>
            <a href="login.php" class="btn btn-navbar m-1">Masuk</a>
        </div>
    </div>
</nav>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body bg-light">
                    <div class="text-center">
                        <h5>Login Aplikasi</h5>
                        <form action="config/aksi_login.php" method="POST">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="d-grid mt-2">
                                <button class="btn btn-navbar" type="submit" name="kirim">MASUK</button>
                            </div>
                        </form>
                        <hr>
                        <p>Belum punya akun? <a href="register.php">Daftar Disini!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="d-flex justify-content-center border-top mt-3 fixed-bottom">
    <p>&copy; Web Galeri Foto | Kamila Putri Herlambang</p>
</footer>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
