<?php
session_start();
require 'dummy.php'; // File ini berisi data produk

// Cek jika ada aksi (tambah, edit, hapus)
if (isset($_POST['tambah'])) {
    $dataproduk[] = [
        $_POST['namaproduk'],
        $_POST['deskripsi'],
        (int) $_POST['harga'],
        $_POST['kategori'],
        (int) $_POST['stok']
    ];
}

// Mengecek apakah ada aksi hapus produk
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];  // Mengambil ID produk yang akan dihapus dan mengonversi ke integer
    unset($dataproduk[$id]);  // Menghapus produk dari array berdasarkan ID
    $dataproduk = array_values($dataproduk); // Mengatur ulang indeks array setelah penghapusan
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h3>Daftar Produk</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <!-- Melakukan loop untuk menampilkan data produk -->
                <?php foreach ($dataproduk as $key => $produk) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td> <!-- Menampilkan nomor urut -->
                        <td><?= htmlspecialchars($produk[0]) ?></td> <!-- Menampilkan nama produk dengan menghindari XSS -->
                        <td><?= htmlspecialchars($produk[1]) ?></td> <!-- Menampilkan deskripsi produk -->
                        <td>Rp <?= number_format($produk[2], 0, ',', '.') ?></td> <!-- Menampilkan harga dalam format rupiah -->
                        <td><?= htmlspecialchars($produk[3]) ?></td> <!-- Menampilkan kategori produk -->
                        <td><?= $produk[4] ?></td> <!-- Menampilkan jumlah stok -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>