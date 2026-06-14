<?php
include "koneksi.php";

$id_pelanggan = $_GET['id_pelanggan'];

/* hapus detail pesanan milik pelanggan */
mysqli_query($koneksi, "
    DELETE detail_pesanan
    FROM detail_pesanan
    JOIN pesanan 
    ON detail_pesanan.id_pesanan = pesanan.id_pesanan
    WHERE pesanan.id_pelanggan = '$id_pelanggan'
");

/* hapus pesanan milik pelanggan */
mysqli_query($koneksi, "
    DELETE FROM pesanan
    WHERE id_pelanggan = '$id_pelanggan'
");

/* hapus pelanggan */
mysqli_query($koneksi, "
    DELETE FROM pelanggan
    WHERE id_pelanggan = '$id_pelanggan'
");

header("Location: daftar_pelanggan.php");
?>