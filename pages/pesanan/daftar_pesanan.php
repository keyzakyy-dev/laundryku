<?php
include "../../config/koneksi.php";

$limit = 5;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$total_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total_data
    FROM pesanan p
    JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
    JOIN layanan l ON dp.id_layanan = l.id_layanan
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
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>

<header class="hero-small">
    <h1>Daftar Pesanan</h1>
    <p>Menampilkan seluruh data pesanan laundry pelanggan</p>

    <div class="container-button">
        <a class="buttonx button-back" href="../../index.php">Kembali</a>
        <a class="buttonx" href="../pelanggan/daftar_pelanggan.php">Daftar Pelanggan</a>
        <a class="buttonx" href="../layanan/daftar_layanan.php">Daftar Layanan</a>
    </div>
</header>

<div class="container">
    <div class="top-section">
        <div>
            <h2 class="judul-left">Data Pesanan Laundry</h2>
            <p class="deskripsi-left">
                Menampilkan seluruh transaksi dan status pesanan laundry pelanggan.
            </p>
        </div>

        <a class="buttonx button-tambah" href="tambah_pesanan.php">
            + Tambah Pesanan
        </a>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "
                SELECT 
                    p.id_pesanan,
                    pl.nama,
                    p.tanggal_pesanan,
                    l.nama_layanan,
                    dp.berat_kg,
                    l.harga_per_kg,
                    (dp.berat_kg * l.harga_per_kg) AS total_harga,
                    p.status_pesanan
                FROM pesanan p
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
                JOIN layanan l ON dp.id_layanan = l.id_layanan
                ORDER BY p.id_pesanan DESC
                LIMIT $limit OFFSET $offset
            ");

            while ($row = mysqli_fetch_array($query)) {
                $status = strtolower($row['status_pesanan']);
            ?>

            <tr>
                <td><?php echo $row['id_pesanan']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['tanggal_pesanan']; ?></td>
                <td><?php echo $row['nama_layanan']; ?></td>
                <td><?php echo $row['berat_kg']; ?> Kg</td>
                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>
                    <?php
                    if ($status == "proses" || $status == "diproses") {
                        echo '<span class="status proses">Diproses</span>';
                    } else if ($status == "selesai") {
                        echo '<span class="status selesai">Selesai</span>';
                    }
                    ?>
                </td>
                <td>
                    <a
                        class="btn-edit"
                        href="edit_status_pesanan.php?id_pesanan=<?php echo $row['id_pesanan']; ?>">
                        Edit Status
                    </a>
                </td>
            </tr>

            <?php } ?>
        </table>

        <?php if ($total_halaman > 1) { ?>
        <div class="pagination">
            <?php if ($halaman > 1) { ?>
                <a href="daftar_pesanan.php?halaman=<?php echo $halaman - 1; ?>">
                    Sebelumnya
                </a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                <a
                    href="daftar_pesanan.php?halaman=<?php echo $i; ?>"
                    class="<?php echo ($i == $halaman) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <?php if ($halaman < $total_halaman) { ?>
                <a href="daftar_pesanan.php?halaman=<?php echo $halaman + 1; ?>">
                    Selanjutnya
                </a>
            <?php } ?>
        </div>
        <?php } ?>
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