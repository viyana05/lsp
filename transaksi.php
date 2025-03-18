<?php
session_start();
require 'dummy.php';

// Ambil ID Paket dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : -1;
if ($id < 0 || !isset($dataproduk[$id])) {
    // Mengecek apakah ID kurang dari 0 atau ID produk tidak ditemukan dalam array $dataproduk
    echo "Produk tidak ditemukan!";
    // Jika kondisi benar, tampilkan pesan error
    exit;
    // Menghentikan eksekusi script agar kode selanjutnya tidak dijalankan
}


$paketTerpilih = $dataproduk[$id];
$harga = $paketTerpilih[2];
$sisaStok = $paketTerpilih[4];

// Variabel untuk form
$notransaksi = "";
$namacustomer = "";
$tanggal = "";
$totalharga = 0;
$pembayaran = 0;
$kembalian = 0;
$pesan = "";
$jumlah = 1;
$diskon = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notransaksi = $_POST['notransaksi'];
    $namacustomer = $_POST['namacustomer'];
    $tanggal = $_POST['tanggal'];
    $pembayaran = isset($_POST['pembayaran']) ? (int) $_POST['pembayaran'] : 0;
    $jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 1;

    if ($jumlah > $sisaStok) {
        $pesan = "Stok tidak mencukupi! Sisa stok: $sisaStok";
    } else {
        $totalharga = $harga * $jumlah;

        if ($jumlah > 5) {
            $diskon = 0.15 * $totalharga;
            $totalharga -= $diskon;
        }

        if (isset($_POST['simpan']) && $pembayaran >= $totalharga) {
            // Kurangi stok langsung di file dummy
            $dataproduk[$id][4] -= $jumlah;
            file_put_contents('dummy.php', "<?php\n\$dataproduk = " . var_export($dataproduk, true) . ";\n");
            // Menyimpan perubahan data stok kembali ke file 'dummy.php' dengan memperbarui array $dataproduk


            // Simpan riwayat transaksi ke session
            $_SESSION['riwayat_penjualan'][] = [
                'notransaksi' => $notransaksi,
                'namacustomer' => $namacustomer,
                'produk' => $paketTerpilih[0],
                'jumlah' => $jumlah,
                'totalharga' => $totalharga,
                'tanggal' => $tanggal,
            ];

            echo "<script>
                alert('Transaksi Berhasil! Stok berhasil diperbarui.');
                window.location.href = 'riwayat_penjual.php';
            </script>";
        }
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar" style="background-color: #dda0dd;">
        <div class="container-fluid">
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex">
                    <a class="nav-link text-black mx-3 fs-5 py-2 px-3" href="home.php">Home</a>
                    <a class="nav-link text-black mx-3 fs-5 py-2 px-3" href="transaksi.php">Transaksi</a>
                </div>
                <a href="index.php" class="text-black mx-3 fs-5">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <h3 class="text-center">TRANSAKSI</h3>
                            <div class="mb-3">
                                <label class="form-label">Nomor Transaksi</label>
                                <input type="text" class="form-control" name="notransaksi" value="<?= htmlspecialchars($notransaksi) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" name="namacustomer" value="<?= htmlspecialchars($namacustomer) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilihan Produk</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($paketTerpilih[0]) ?>" name="paket" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Produk</label>
                                <input type="text" class="form-control" name="harga" value="<?= htmlspecialchars($harga) ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Produk</label>
                                <input type="number" class="form-control" name="jumlah" value="<?= htmlspecialchars($jumlah) ?>" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-black w-40" style="background-color: #dda0dd" name="hitung_total">Hitung Total Harga</button>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Total Harga (Setelah Diskon)</label>
                                <input type="text" class="form-control" name="totalharga" value="<?= $totalharga ?>" readonly>
                            </div>
                            <?php if ($diskon > 0) : ?>
                                <div class="alert alert-success">Anda mendapatkan diskon Rp <?= number_format($diskon, 0, ',', '.') ?>!</div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label">Pembayaran</label>
                                <input type="text" class="form-control" name="pembayaran" value="<?= $pembayaran ?>">
                            </div>
                            <button type="submit" class="btn btn-black w-40" style="background-color: #dda0dd" name="hitung_kembalian">Hitung Kembalian</button>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Kembalian</label>
                                <input type="text" class="form-control" name="kembalian" value="<?= $kembalian ?>" readonly>
                            </div>
                            <button type="submit" class="btn btn-black w-40" style="background-color: #dda0dd" name="simpan">Simpan</button>
                            <?php if ($pesan) : ?>
                                <div class="alert alert-warning mt-3"> <?= $pesan ?> </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white text-black text-center py-1">
        <p>&copy; <?php echo date("Y"); ?>@Copyright viyana</p>
    </footer>
</body>

</html>


<!-- calenge 

    1. rapikan hargaa
    2. bikin 2 user pembeli dan admin menggunakan session, admin memiliki halaman produk dan riwayat penjualan 
    3. mengurangi stok jika melakukan pembelian 
    4. mendapatkan diskon jika pembelian lebih dari 5 diskon ny 15%
    5. halaman produk berisi detail produk jika stok habis maka tampilkan stok tidak tersedia 
       jika stok kurang dari 3 tampilkan stok menipis

-->