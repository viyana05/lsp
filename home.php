<?php
session_start();
require 'dummy.php';

// Periksa apakah ada pembaruan stok dari transaksi
if (isset($_SESSION['updated_stock'])) {
    $dataproduk = $_SESSION['updated_stock'];
    unset($_SESSION['updated_stock']); // Hapus sesi setelah dipakai
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technopark Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar" style="background-color: #dda0dd;">
        <div class="container-fluid">
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex">
                    <a class="nav-link text-black mx-3 fs-5 py-2 px-3" href="#">Home</a>
                    <a class="nav-link text-black mx-3 fs-5 py-2 px-3" href="transaksi.php">Transaksi</a>
                </div>
                <a href="index.php" class="text-black mx-3 fs-5">Logout</a>
            </div>
        </div>
    </nav>

    <div class="mb-4 p-0">
        <div class="container-fluid p-0">
            <img src="img/banner.png" class="img-fluid w-100" alt="" style="height: 400px; object-fit: cover; border-radius: 10px; margin-top: -20px;">
        </div>
    </div>

    <div class="container-fluid mt-5">
        <h5 class="text-left mb-4">Daftar Produk Technopark Gallery SMKN 2 BANJARMASIN</h5>
        <div class="row justify-content-start">
            <?php foreach ($dataproduk as $index => $paket) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100" style="height: 400px;">
                        <img src="img/<?= $paket[3] ?>" class="card-img-top" alt="<?= $paket[0] ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"> <?= $paket[0] ?> </h6>
                            <p class="card-text"> <?= $paket[1] ?> </p>
                            <div class="d-flex justify-content-start align-items-center mt-auto">
                                <p class="card-text mb-0"><strong>Rp <?= number_format($paket[2], 0, ',', '.') ?></strong></p>
                            </div>
                            <p class="card-text mt-2">
                                Stok:
                                <?php
                                if ($paket[4] == 0) {
                                    echo "<span class='text-danger'>Tidak tersedia</span>";
                                } elseif ($paket[4] < 3) {
                                    echo "<span class='text-warning'>Menipis ({$paket[4]})</span>";
                                } else {
                                    echo $paket[4];
                                }
                                ?>
                            </p>
                            <a href="transaksi.php?id=<?= $index ?>" class="btn btn-black w-100 mt-2 <?php echo ($paket[4] == 0) ? 'disabled' : ''; ?>" style="background-color: #dda0dd">Pilih Produk</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-white text-black text-center py-1">
        <p>&copy; <?php echo date("Y"); ?>@Copyright viyana</p>
    </footer>
</body>

</html>