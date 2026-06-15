<?php
include "koneksi.php";

function buatId($koneksi, $tabel, $kolom, $prefix)
{
    $query = mysqli_query($koneksi, "
        SELECT MAX($kolom) AS id_terakhir FROM $tabel
    ");

    $data = mysqli_fetch_array($query);
    $id_terakhir = $data['id_terakhir'];

    if ($id_terakhir == null) {
        $nomor = 1;
    } else {
        $nomor = (int) substr($id_terakhir, 2) + 1;
    }

    return $prefix . str_pad($nomor, 3, '0', STR_PAD_LEFT);
}

if (isset($_POST['simpan'])) {

    $id_pesanan      = buatId($koneksi, "pesanan", "id_pesanan", "PS");
    $id_detail       = buatId($koneksi, "detail_pesanan", "id_detail", "DT");
    $id_pesanan      = $_POST['id_pesanan'];
    $id_detail       = $_POST['id_detail'];
    $id_pelanggan    = $_POST['id_pelanggan'];
    $id_layanan      = $_POST['id_layanan'];
    $tanggal_pesanan = $_POST['tanggal_pesanan'];
    $status_pesanan  = $_POST['status_pesanan'];
    $berat_kg        = $_POST['berat_kg'];

    // INSERT TABEL PESANAN
    $query_pesanan = mysqli_query($koneksi, "
        INSERT INTO pesanan
        VALUES (
            '$id_pesanan',
            '$id_pelanggan',
            '$tanggal_pesanan',
            '$status_pesanan'
        )
    ");

    // INSERT TABEL DETAIL PESANAN
    $query_detail = mysqli_query($koneksi, "
        INSERT INTO detail_pesanan
        VALUES (
            '$id_detail',
            '$id_pesanan',
            '$id_layanan',
            '$berat_kg'
        )
    ");

    if ($query_pesanan && $query_detail) {

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

        <script>

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pesanan berhasil ditambahkan',
                confirmButtonColor: '#2b69fe'
            }).then(() => {
                window.location='daftar_pesanan.php';
            });

        </script>
        ";

    } else {

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

        <script>

            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Pesanan gagal ditambahkan',
                confirmButtonColor: '#e53935'
            });

        </script>
        ";

    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pesanan</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header class="hero-small">

    <h1>Tambah Pesanan</h1>

    <p>
        Form transaksi laundry pelanggan
    </p>

    <div class="container-button">

        <a class="buttonx button-back" href="daftar_pesanan.php">
            Kembali
        </a>

    </div>

</header>

<div class="container">

    <div class="form-container modern-form">

        <div class="form-header">

            <h2>Form Pesanan Laundry</h2>

            <p>
                Lengkapi data transaksi laundry dengan benar.
            </p>

        </div>

        <form method="POST">

            <div class="form-row">

                <div class="form-group">

                    <label>ID Pesanan</label>

                    <input
                        type="text"
                        name="id_pesanan"
                        placeholder="Contoh : PS001"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>ID Detail</label>

                    <input
                        type="text"
                        name="id_detail"
                        placeholder="Contoh : DT001"
                        required
                    >

                </div>

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label>Pelanggan</label>

                    <select name="id_pelanggan" required>

                        <option value="">
                            -- Pilih Pelanggan --
                        </option>

                        <?php

                        $pelanggan = mysqli_query($koneksi, "
                            SELECT * FROM pelanggan
                        ");

                        while ($data = mysqli_fetch_array($pelanggan)) {

                        ?>

                        <option value="<?php echo $data['id_pelanggan']; ?>">

                            <?php echo $data['id_pelanggan']; ?>
                            -
                            <?php echo $data['nama']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>Layanan</label>

                    <select
                        name="id_layanan"
                        id="layanan"
                        required>

                        <option value="">
                            -- Pilih Layanan --
                        </option>

                        <?php

                        $layanan = mysqli_query($koneksi, "
                            SELECT * FROM layanan
                        ");

                        while ($data = mysqli_fetch_array($layanan)) {

                        ?>

                        <option
                            value="<?php echo $data['id_layanan']; ?>"
                            data-harga="<?php echo $data['harga_per_kg']; ?>">

                            <?php echo $data['nama_layanan']; ?>
                            -
                            Rp <?php echo number_format($data['harga_per_kg'],0,',','.'); ?>/kg

                        </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label>Berat Cucian (Kg)</label>

                    <input
                        type="number"
                        name="berat_kg"
                        id="berat"
                        step="0.1"
                        placeholder="Contoh : 3"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Tanggal Pesanan</label>

                    <input
                        type="date"
                        name="tanggal_pesanan"
                        required
                    >

                </div>

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label>Status Pesanan</label>

                    <select name="status_pesanan" required>

                        <option value="Diproses">
                            Diproses
                        </option>

                        <option value="Selesai">
                            Selesai
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Total Harga</label>

                    <input
                        type="text"
                        id="total"
                        readonly
                        placeholder="Rp 0"
                    >

                </div>

            </div>

            <button
                type="submit"
                name="simpan"
                class="submit-btn">

                Simpan Pesanan

            </button>

        </form>

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

const layanan = document.getElementById('layanan');
const berat   = document.getElementById('berat');
const total   = document.getElementById('total');

function hitungTotal() {

    let harga = layanan.options[
        layanan.selectedIndex
    ].getAttribute('data-harga');

    let beratKg = berat.value;

    if (harga && beratKg) {

        let hasil = harga * beratKg;

        total.value =
            "Rp " + hasil.toLocaleString('id-ID');

    }

    else {

        total.value = "";

    }

}

layanan.addEventListener('change', hitungTotal);

berat.addEventListener('input', hitungTotal);

</script>

</body>
</html>
