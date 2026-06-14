<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="hero-small">

    <h1>Daftar Pesanan</h1>
    <p>Menampilkan seluruh data pesanan laundry pelanggan</p>

    <div class="container-button">

        <a class="buttonx button-back" href="index.php">
            Kembali
        </a>

        <a class="buttonx" href="daftar_pelanggan.php">
            Daftar Pelanggan
        </a>

        <a class="buttonx" href="daftar_layanan.php">
            Daftar Layanan
        </a>

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
                <th>ID Pelanggan</th>
                <th>Tanggal Pesanan</th>
                <th>Status Pesanan</th>
                <th>Aksi</th>
            </tr>

            <?php

            $query = mysqli_query($koneksi, "
                SELECT * FROM pesanan
            ");

            while ($row = mysqli_fetch_array($query)) {

                $status = strtolower($row['status_pesanan']);

            ?>

            <tr>

                <td>
                    <?php echo $row['id_pesanan']; ?>
                </td>

                <td>
                    <?php echo $row['id_pelanggan']; ?>
                </td>

                <td>
                    <?php echo $row['tanggal_pesanan']; ?>
                </td>

                <td>

                    <?php
                        if ($status == "proses" || $status == "diproses") {
                            echo '<span class="status proses">Diproses</span>';
                        }

                        else if ($status == "selesai") {
                            echo '<span class="status selesai">Selesai</span>';
                        }
                        ?>
                </td>

                <td>
                    <a class="btn-edit"
                    href="edit_status_pesanan.php?id_pesanan=<?php echo $row['id_pesanan']; ?>">
                        Edit Status
                    </a>

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

</body>
</html>