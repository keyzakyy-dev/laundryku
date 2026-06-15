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

$notif = "";

if (isset($_POST['simpan'])) {

    $id_pelanggan = buatId($koneksi, "pelanggan", "id_pelanggan", "PL");
    $nama         = $_POST['nama'];
    $no_telp      = $_POST['no_telp'];
    $email        = $_POST['email'];
    $alamat       = $_POST['alamat'];

    $query = mysqli_query($koneksi, "
        INSERT INTO pelanggan
        VALUES (
            '$id_pelanggan',
            '$nama',
            '$no_telp',
            '$email',
            '$alamat'
        )
    ");

    if ($query) {

        $notif = "sukses";

    } else {

        $notif = "gagal";

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pelanggan</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<header class="hero-small">

    <h1>Tambah Pelanggan</h1>

    <p>
        Form untuk menambahkan data pelanggan baru ke dalam sistem laundry
    </p>

    <div class="container-button">

        <a class="buttonx button-back" href="daftar_pelanggan.php">
            Kembali
        </a>

    </div>

</header>

<div class="container">

    <div class="form-container modern-form">

        <div class="form-header">

            <h2>Form Data Pelanggan</h2>

            <p>
                Lengkapi seluruh data pelanggan dengan benar.
            </p>

        </div>

        <form method="POST">


            <div class="form-row">

                <div class="form-group">

                    <label>Nama Pelanggan</label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama pelanggan"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>No Telepon</label>

                    <input
                        type="text"
                        name="no_telp"
                        placeholder="08xxxxxxxxxx"
                        required
                    >

                </div>

            </div>

            <div class="form-group full">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="example@gmail.com"
                    required
                >

            </div>

            <div class="form-group full">

                <label>Alamat</label>

                <textarea
                    name="alamat"
                    placeholder="Masukkan alamat pelanggan"
                    required
                ></textarea>

            </div>

            <button
                type="submit"
                name="simpan"
                class="submit-btn">

                Simpan Data Pelanggan

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

<?php if ($notif == "sukses") { ?>

<script>

Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data pelanggan berhasil ditambahkan',
    confirmButtonColor: '#2b69fe'
}).then(() => {

    window.location = 'daftar_pelanggan.php';

});

</script>

<?php } ?>

<?php if ($notif == "gagal") { ?>

<script>

Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: 'Data pelanggan gagal ditambahkan',
    confirmButtonColor: '#e53935'
});

</script>

<?php } ?>

</body>
</html>