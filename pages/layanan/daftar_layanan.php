<?php
include "../../config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Layanan</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>

<header class="hero-small">
    <h1>Daftar Layanan</h1>
    <p>Informasi layanan laundry yang tersedia dalam sistem</p>

    <div class="container-button">
        <a class="buttonx button-back" href="../../index.php">Kembali</a>
        <a class="buttonx" href="../pelanggan/daftar_pelanggan.php">Daftar Pelanggan</a>
        <a class="buttonx" href="../pesanan/daftar_pesanan.php">Daftar Pesanan</a>
    </div>
</header>

<div class="container">
    <div class="top-section">
        <div>
            <h2 class="judul-left">Data Layanan Laundry</h2>
            <p class="deskripsi-left">
                Menampilkan seluruh jenis layanan laundry beserta harga per kilogram.
            </p>
        </div>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>ID Layanan</th>
                <th>Nama Layanan</th>
                <th>Harga per Kg</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM layanan");

            while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr>
                <td><?php echo $row['id_layanan']; ?></td>
                <td><strong><?php echo $row['nama_layanan']; ?></strong></td>
                <td>
                    Rp <?php echo number_format($row['harga_per_kg'], 0, ',', '.'); ?>
                </td>
            </tr>

            <?php } ?>
        </table>
    </div>
</div>

<footer class="footer-laundry">
    <h2>Sistem Pengelolaan Laundry</h2>
    <p>Dashboard riwayat pesanan, layanan favorit, dan data tim pengelola</p>
    <div class="copyright">
        © 2026 Sistem Laundry Team
    </div>
</footer>

</body>
</html>