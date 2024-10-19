<?php
session_start();
include '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = "user";
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check_user) > 0) {
        $script = "
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Username sudah digunakan!',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true
            });
        ";
    } else {
        $insert = "INSERT INTO users (username, password, role, nama_lengkap) 
                   VALUES ('$username', '$hashed_password', '$role', '$nama')";
        if (mysqli_query($conn, $insert)) {
            $script = "
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Pendaftaran berhasil!',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true
                });
                setTimeout(function() {
                    window.location.href = 'index.php'; 
                }, 3000);
            ";
        } else {
            $script = "
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Pendaftaran gagal!',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true
                });
            ";
        }
    }

    echo "<script>{$script}</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $judul; ?> </title>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../vendor/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>


    <section class=" py-3 py-md-5 mt-5">
        <div class="container">
            <center>
                <h3 class="text-dark"><?= $judul; ?></h3>
            </center>
            <br>
            <div class="row justify-content-center">

                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <label for="username" class="form-label" style="color: black;">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <label for="password" class="form-label" style="color: black;">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <label for="nama" class="form-label" style="color: black;">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid my-3">
                                            <button class="btn btn-primary btn-sm w-100" type="submit" name="register">Daftar</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Sudah Mempunyai Akun? <a href="index.php" class="link-primary text-decoration-none">Login Disini</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include "footer.php"; ?>
    <?php include "plugin.php"; ?>

    <script>
        <?php if (isset($script)) {
            echo $script;
        } ?>
    </script>

</body>

</html>