<?php
include "../../config/koneksi.php";

$notif = "";

$id_pesanan = $_GET['id_pesanan'];

$query = mysqli_query($koneksi, "
    SELECT * FROM pesanan
    WHERE id_pesanan = '$id_pesanan'
");

$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $status_pesanan = $_POST['status_pesanan'];

    $update = mysqli_query($koneksi, "
        UPDATE pesanan
        SET status_pesanan = '$status_pesanan'
        WHERE id_pesanan = '$id_pesanan'
    ");

    if ($update) {
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
    <title>Edit Status Pesanan</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<header class="hero-small">

    <h1>Edit Status Pesanan</h1>
    <p>Form untuk mengubah status pesanan laundry pelanggan</p>

    <div class="container-button">
        <a href="daftar_pesanan.php" class="buttonx button-back">
            Kembali
        </a>
    </div>

</header>

<div class="container">

    <div class="form-container modern-form">

        <div class="form-header">
            <h2>Update Status Pesanan</h2>
            <p>Silakan ubah status pesanan sesuai proses laundry.</p>
        </div>

        <form method="POST">

            <div class="form-group full">
                <label>ID Pesanan</label>
                <input
                    type="text"
                    value="<?php echo $data['id_pesanan']; ?>"
                    readonly
                >
            </div>

            <div class="form-group full">
                <label>Status Pesanan</label>

                <select name="status_pesanan" required>
                    <option
                        value="Diproses"
                        <?php if ($data['status_pesanan'] == "Diproses") echo "selected"; ?>>
                        Diproses
                    </option>

                    <option
                        value="Selesai"
                        <?php if ($data['status_pesanan'] == "Selesai") echo "selected"; ?>>
                        Selesai
                    </option>
                </select>
            </div>

            <button type="submit" name="update" class="submit-btn">
                Update Status
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
    text: 'Status pesanan berhasil diperbarui',
    customClass: {
        confirmButton: 'swal-btn-primary'
    }
}).then(() => {
    window.location = 'daftar_pesanan.php';
});
</script>

<?php } ?>

<?php if ($notif == "gagal") { ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: 'Status pesanan gagal diperbarui',
    customClass: {
        confirmButton: 'swal-btn-danger'
    }
});
</script>

<?php } ?>

</body>
</html>