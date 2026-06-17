<?php
include "config/koneksi.php";

$waktu_query = mysqli_query($koneksi, "SELECT NOW() as waktu_sekarang");
$waktu_data  = mysqli_fetch_array($waktu_query);

$limit = 5;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$total_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total_data
    FROM detail_pesanan dp
    JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
    JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
    JOIN layanan ly ON dp.id_layanan = ly.id_layanan
");

$total_data = mysqli_fetch_assoc($total_query)['total_data'];
$total_halaman = ceil($total_data / $limit);

if ($total_halaman > 0 && $halaman > $total_halaman) {
    $halaman = $total_halaman;
}

$offset = ($halaman - 1) * $limit;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Laundry</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="hero">
    <h1>Sistem Pengelolaan Laundry</h1>
    <p>Dashboard riwayat pesanan, layanan favorit, dan data tim pengelola</p>

    <div style="margin-top: 12px; font-size: 14px; color: var(--muted-foreground);">
        Waktu Server: <strong><?php echo $waktu_data['waktu_sekarang']; ?></strong>
    </div>

    <div class="container-button">
        <a class="buttonx" href="pages/pelanggan/daftar_pelanggan.php">Daftar Pelanggan</a>
        <a class="buttonx" href="pages/layanan/daftar_layanan.php">Daftar Layanan</a>
        <a class="buttonx" href="pages/pesanan/daftar_pesanan.php">Daftar Pesanan</a>
        <a class="buttonx" href="pages/statistik/statistik.php">Statistik</a>
    </div>
</header>

<main>

<div class="container">
    <h2 class="judul">Riwayat Pesanan</h2>
    <p class="deskripsi">Menampilkan 5 data pesanan laundry terbaru.</p>

    <div class="content">
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Tanggal Order</th>
                <th>Nama Layanan</th>
                <th>Subtotal</th>
                <th>Status Pesanan</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "
                SELECT
                    pl.nama,
                    ps.tanggal_pesanan,
                    ly.nama_layanan,
                    ly.harga_per_kg * dp.berat_kg AS subtotal,
                    ps.status_pesanan
                FROM detail_pesanan dp
                JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
                JOIN pelanggan pl ON ps.id_pelanggan = pl.id_pelanggan
                JOIN layanan ly ON dp.id_layanan = ly.id_layanan
                ORDER BY ps.tanggal_pesanan DESC, dp.id_detail DESC
                LIMIT $limit OFFSET $offset
            ");

            while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr>
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

        <?php if ($total_halaman > 1) { ?>
        <div class="pagination">
            <?php if ($halaman > 1) { ?>
                <a href="index.php?halaman=<?php echo $halaman - 1; ?>">Sebelumnya</a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                <a
                    href="index.php?halaman=<?php echo $i; ?>"
                    class="<?php echo ($i == $halaman) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <?php if ($halaman < $total_halaman) { ?>
                <a href="index.php?halaman=<?php echo $halaman + 1; ?>">Selanjutnya</a>
            <?php } ?>
        </div>
        <?php } ?>
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
                <img src="assets/img/zaky.png" alt="Sayyid Dzaky Farhan">
            </figure>
            <div class="team-info">
                <span class="role">Institut Teknologi Garut</span>
                <span class="nama">Sayyid Dzaky Farhan</span>
                <span class="npm">2406007</span>
            </div>
        </div>

        <div class="image-wrapper team-card">
            <figure>
                <img src="assets/img/rahmat.png" alt="Rahmat Apandi">
            </figure>
            <div class="team-info">
                <span class="role">Institut Teknologi Garut</span>
                <span class="nama">Rahmat Apandi</span>
                <span class="npm">2406006</span>
            </div>
        </div>

        <div class="image-wrapper team-card">
            <figure>
                <img src="assets/img/azhari.png" alt="Azhari Ahmad Fauzani">
            </figure>
            <div class="team-info">
                <span class="role">Institut Teknologi Garut</span>
                <span class="nama">Azhari Ahmad Fauzani</span>
                <span class="npm">2406107</span>
            </div>
        </div>

        <div class="image-wrapper team-card">
            <figure>
                <img src="assets/img/hilma.png" alt="Hilma Putri Andriyani">
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