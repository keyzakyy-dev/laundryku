<?php
include "koneksi.php";

// Query untuk mengambil waktu server
$waktu_query = mysqli_query($koneksi, "SELECT NOW() as waktu_sekarang, CURDATE() as tanggal_hari_ini, CURTIME() as jam_sekarang");
$waktu_data  = mysqli_fetch_array($waktu_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Laundry</title>
</head>
<body>

<header class="hero">
    <h1>Sistem Pengelolaan Laundry</h1>
    <p>Dashboard riwayat pesanan, layanan favorit, dan data tim pengelola</p>
    
    <!-- TAMPILAN WAKTU -->
    <div style="margin-top: 12px; font-size: 14px; color: var(--muted-foreground);">
        🕒 Waktu Server: <strong><?php echo $waktu_data['waktu_sekarang']; ?></strong>
    </div>
    
    <div class="container-button">
        <a class="buttonx" href="daftar_pelanggan.php">Daftar Pelanggan</a>
        <a class="buttonx" href="daftar_layanan.php">Daftar Layanan</a>
        <a class="buttonx" href="daftar_pesanan.php">Daftar Pesanan</a>
    </div>
</header>

<main>

<div class="container">
    <h2 class="judul">Riwayat Pesanan</h2>
    <p class="deskripsi">Menampilkan 5 data pesanan laundry terbaru.</p>

    <div class="content">
        <table>
            <tr>
                <th>Detail ID</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Order</th>
                <th>Nama Layanan</th>
                <th>Subtotal</th>
                <th>Status Pesanan</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "
                SELECT
                    dp.id_detail,
                    pl.nama,
                    ps.tanggal_pesanan,
                    ly.nama_layanan,
                    ly.harga_per_kg * dp.berat_kg AS subtotal,
                    ps.status_pesanan
                FROM detail_pesanan dp
                JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
                JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
                JOIN layanan ly ON dp.id_layanan = ly.id_layanan
                ORDER BY ps.tanggal_pesanan DESC
                LIMIT 5
            ");

            while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr>
                <td><?php echo $row['id_detail']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['tanggal_pesanan']; ?></td>
                <td><?php echo $row['nama_layanan']; ?></td>
                <td>Rp <?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
                <td>
                    <span class="status">
                        <?php echo $row['status_pesanan']; ?>
                    </span>
                </td>
            </tr>

            <?php } ?>
        </table>
    </div>
</div>

<div class="container">
    <h2 class="judul">Layanan Sering Dipilih</h2>
    <p class="deskripsi">Menampilkan jenis layanan laundry yang paling sering digunakan pelanggan.</p>

    <div class="content">
        <table class="table-layanan-favorit">
            <tr>
                <th>Layanan</th>
                <th>Jumlah Dipilih</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "
                SELECT
                    l.nama_layanan,
                    COUNT(dp.id_layanan) AS jumlah_dipilih
                FROM detail_pesanan dp
                JOIN layanan l ON dp.id_layanan = l.id_layanan
                GROUP BY l.nama_layanan
                ORDER BY jumlah_dipilih DESC
            ");

            while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr>
                <td><?php echo $row['nama_layanan']; ?></td>
                <td><?php echo $row['jumlah_dipilih']; ?> kali</td>
            </tr>

            <?php } ?>
        </table>
    </div>
</div>

<div class="container">
    <h2 class="judul">Our Team</h2>
    <p class="deskripsi">Kelompok pengembang Sistem Pengelolaan Laundry.</p>

    <div class="image-content">

    <div class="image-wrapper team-card">
        <figure>
            <img src="img/zaky.png" alt="Sayyid Dzaky Farhan">
        </figure>

        <div class="team-info">
            <span class="role">Institut Teknologi Garut</span>
            <span class="nama">Sayyid Dzaky Farhan</span>
            <span class="npm">2406007</span>
        </div>
    </div>

    <div class="image-wrapper team-card">
        <figure>
            <img src="img/rahmat.png" alt="Rahmat Apandi">
        </figure>

        <div class="team-info">
            <span class="role">Institut Teknologi Garut</span>
            <span class="nama">Rahmat Apandi</span>
            <span class="npm">2406006</span>
        </div>
    </div>

    <div class="image-wrapper team-card">
        <figure>
            <img src="img/azhari.png" alt="Azhari Ahmad Fauzani">
        </figure>

        <div class="team-info">
            <span class="role">Institut Teknologi Garut</span>
            <span class="nama">Azhari Ahmad Fauzani</span>
            <span class="npm">2406107</span>
        </div>
    </div>

    <div class="image-wrapper team-card">
        <figure>
            <img src="img/hilma.png" alt="Hilma Putri Andriyani">
        </figure>

        <div class="team-info">
            <span class="role">Institut Teknologi Garut</span>
            <span class="nama">Hilma Putri Andriyani</span>
            <span class="npm">2406018</span>
        </div>
    </div>

</div>
</div>

</main>

<footer class="footer-laundry">
    <h2>Sistem Pengelolaan Laundry</h2>
    <p>Dashboard riwayat pesanan, layanan favorit, dan data tim pengelola</p>
    <div class="copyright">
        © 2026 Sistem Laundry Team
    </div>
</footer>

</body>
</html>
