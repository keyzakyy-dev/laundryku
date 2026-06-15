<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<header class="hero-small">

    <h1>Daftar Pelanggan</h1>
    <p>Data pelanggan laundry yang telah terdaftar dalam sistem</p>

    <div class="container-button">
        <a class="buttonx button-back" href="index.php">
            Kembali
        </a>

        <a class="buttonx" href="daftar_layanan.php">
            Daftar Layanan
        </a>

        <a class="buttonx" href="daftar_pesanan.php">
            Daftar Pesanan
        </a>
    </div>

</header>

<div class="container">

    <div class="top-section">

        <div>
            <h2 class="judul-left">Data Pelanggan</h2>
            <p class="deskripsi-left">
                Menampilkan seluruh pelanggan yang terdaftar.
            </p>
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

            $query = mysqli_query($koneksi, "SELECT * FROM pelanggan");

            while ($row = mysqli_fetch_array($query)) {

            ?>

            <tr>

                <td><?php echo $row['id_pelanggan']; ?></td>

                <td>
                    <strong><?php echo $row['nama']; ?></strong>
                </td>

                <td><?php echo $row['no_telp']; ?></td>

                <td><?php echo $row['alamat']; ?></td>

                <td><?php echo $row['email']; ?></td>

                <td>

                    <div class="aksi-button">

                        <a class="btn-hapus"
                        href="hapus_pelanggan.php?id_pelanggan=<?php echo $row['id_pelanggan']; ?>"
                        onclick="confirmHapus(event, this.href)">
                            Hapus
                        </a>

                    </div>

                </td>

            </tr>

            <?php
            }
            ?>

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

<script>

function confirmHapus(event, url) {

    event.preventDefault();

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data pelanggan akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53935',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#fff',
        borderRadius: '12px'
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