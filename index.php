<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body
    class="d-flex justify-content-center align-items-center bg-light"
    style="height: 100vh; background: url('img/background.png') no-repeat center center; background-size: 200%;">
    <?php
    session_start();

    // Data User
    $users = [
        "admin" => "admin123",
        "userlsp" => "smk"
    ];

    // Cek apakah request menggunakan method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek apakah username dan password cocok
        if (isset($users[$username]) && $users[$username] === $password) {
            $_SESSION['username'] = $username; // Simpan username di session

            // Tentukan role berdasarkan username
            if ($username === "admin") {
                $_SESSION['role'] = "admin";
                header("Location: admin_produk.php"); // Redirect ke halaman admin
            } else {
                $_SESSION['role'] = "pembeli";
                header("Location: home.php"); // Redirect ke halaman pembeli
            }
            exit(); // Menghentikan eksekusi kode
        } else {
            // Jika salah, kembali ke halaman login
            echo "<script>
                alert('USERNAME ATAU PASSWORD SALAH!');
                window.location.href='index.php';
              </script>";
        }
    }

    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-white p-3 shadow" style="width: 120px; height: 120px; background: url('img/logo.jpg') no-repeat center center; background-size: 80%;"></div>
                </div>


                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-black w-100" style="background-color: #dda0dd;">Login</button>
                        </form>

                        <!-- peringatan untuk user atau pass salah -->
                        <?php if (isset($errorMsg)) {
                            echo "<p class='error'>$errorMsg</p>";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for features like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>