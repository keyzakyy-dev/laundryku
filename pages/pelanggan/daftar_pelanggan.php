<?php
include "../../config/koneksi.php";

$limit = 5;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$total_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total_data 
    FROM pelanggan
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
    <title>Daftar Pelanggan</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<header class="hero-small">
    <h1>Daftar Pelanggan</h1>
    <p>Data pelanggan laundry yang telah terdaftar dalam sistem</p>

    <div class="container-button">
        <a class="buttonx button-back" href="../../index.php">Kembali</a>
        <a class="buttonx" href="../layanan/daftar_layanan.php">Daftar Layanan</a>
        <a class="buttonx" href="../pesanan/daftar_pesanan.php">Daftar Pesanan</a>
    </div>
</header>

<div class="container">
    <div class="top-section">
        <div>
            <h2 class="judul-left">Data Pelanggan</h2>
            <p class="deskripsi-left">Menampilkan seluruh pelanggan yang terdaftar.</p>
        </div>

        <a class="buttonx button-tambah" href="tambah_pelanggan.php">
            + Tambah Pelanggan
        </a>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>

            <?php
            $query = mysqli_query($koneksi, "
                SELECT * FROM pelanggan 
                LIMIT $limit OFFSET $offset
            ");

            while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr>
                <td><?php echo $row['id_pelanggan']; ?></td>
                <td><strong><?php echo $row['nama']; ?></strong></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <div class="aksi-button">
                        <a
                            class="btn-hapus"
                            href="hapus_pelanggan.php?id_pelanggan=<?php echo $row['id_pelanggan']; ?>"
                            onclick="confirmHapus(event, this.href)">
                            Hapus
                        </a>
                    </div>
                </td>
            </tr>

            <?php } ?>
        </table>

        <?php if ($total_halaman > 1) { ?>
        <div class="pagination">
            <?php if ($halaman > 1) { ?>
                <a href="daftar_pelanggan.php?halaman=<?php echo $halaman - 1; ?>">
                    Sebelumnya
                </a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                <a
                    href="daftar_pelanggan.php?halaman=<?php echo $i; ?>"
                    class="<?php echo ($i == $halaman) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <?php if ($halaman < $total_halaman) { ?>
                <a href="daftar_pelanggan.php?halaman=<?php echo $halaman + 1; ?>">
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

<script>
function confirmHapus(event, url) {
    event.preventDefault();

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data pelanggan akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'swal-btn-danger',
            cancelButton: 'swal-btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data pelanggan berhasil dihapus.',
                icon: 'success',
                timer: 1200,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = url;
            }, 1200);
        }
    });
}
</script>

</body>
</html>