<?php
session_start();
$riwayatPenjualan = $_SESSION['riwayat_penjualan'] ?? [];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Riwayat Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h3>Riwayat Penjualan</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Nama Customer</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Periksa apakah ada data riwayat penjualan -->
                <?php if (count($riwayatPenjualan) > 0): ?>
                    <?php foreach ($riwayatPenjualan as $riwayat) : ?>
                        <tr>
                            <td><?= htmlspecialchars($riwayat['notransaksi']) ?></td>
                            <td><?= htmlspecialchars($riwayat['namacustomer']) ?></td>
                            <td><?= htmlspecialchars($riwayat['produk']) ?></td>
                            <td><?= htmlspecialchars($riwayat['jumlah']) ?></td>
                            <td>Rp <?= number_format($riwayat['totalharga'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($riwayat['tanggal']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Tombol Kembali ke Home -->
        <div class="text-center mt-4">
            <a href="home.php" class="btn btn-black w-40" style="background-color: #dda0dd">Kembali ke Home</a>
        </div>
    </div>

</body>

</html>