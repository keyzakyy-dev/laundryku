<?php
include "../../config/koneksi.php";

function ambilNilai($koneksi, $sql, $kolom)
{
    $query = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_assoc($query);

    if (!$data || $data[$kolom] == null) {
        return 0;
    }

    return $data[$kolom];
}

$total_pelanggan = ambilNilai($koneksi, "
    SELECT COUNT(*) AS total 
    FROM pelanggan
", "total");

$total_pesanan = ambilNilai($koneksi, "
    SELECT COUNT(*) AS total 
    FROM pesanan
", "total");

$pesanan_diproses = ambilNilai($koneksi, "
    SELECT COUNT(*) AS total
    FROM pesanan
    WHERE LOWER(status_pesanan) IN ('proses', 'diproses')
", "total");

$pesanan_selesai = ambilNilai($koneksi, "
    SELECT COUNT(*) AS total
    FROM pesanan
    WHERE LOWER(status_pesanan) = 'selesai'
", "total");

$total_pendapatan = ambilNilai($koneksi, "
    SELECT SUM(l.harga_per_kg * dp.berat_kg) AS total
    FROM detail_pesanan dp
    JOIN layanan l ON dp.id_layanan = l.id_layanan
", "total");

$total_berat = ambilNilai($koneksi, "
    SELECT SUM(berat_kg) AS total
    FROM detail_pesanan
", "total");

$status_labels = [];
$status_values = [];

$query_status = mysqli_query($koneksi, "
    SELECT status_pesanan, COUNT(*) AS jumlah
    FROM pesanan
    GROUP BY status_pesanan
    ORDER BY jumlah DESC
");

while ($row = mysqli_fetch_assoc($query_status)) {
    $status_labels[] = $row['status_pesanan'];
    $status_values[] = (int) $row['jumlah'];
}

$layanan_labels = [];
$layanan_values = [];

$query_layanan = mysqli_query($koneksi, "
    SELECT l.nama_layanan, COUNT(dp.id_layanan) AS jumlah
    FROM detail_pesanan dp
    JOIN layanan l ON dp.id_layanan = l.id_layanan
    GROUP BY l.nama_layanan
    ORDER BY jumlah DESC
");

while ($row = mysqli_fetch_assoc($query_layanan)) {
    $layanan_labels[] = $row['nama_layanan'];
    $layanan_values[] = (int) $row['jumlah'];
}

$pendapatan_labels = [];
$pendapatan_values = [];

$query_pendapatan = mysqli_query($koneksi, "
    SELECT l.nama_layanan, SUM(l.harga_per_kg * dp.berat_kg) AS total
    FROM detail_pesanan dp
    JOIN layanan l ON dp.id_layanan = l.id_layanan
    GROUP BY l.nama_layanan
    ORDER BY total DESC
");

while ($row = mysqli_fetch_assoc($query_pendapatan)) {
    $pendapatan_labels[] = $row['nama_layanan'];
    $pendapatan_values[] = (float) $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Laundry</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .statistik-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 18px;
        }

        .statistik-container {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.03);
        }

        .statistik-container.full {
            grid-column: 1 / -1;
        }

        .statistik-header {
            margin-bottom: 16px;
        }

        .statistik-header h3 {
            margin: 0;
            color: var(--foreground);
            font-size: 1rem;
            font-weight: 800;
        }

        .statistik-header p {
            margin: 4px 0 0;
            color: var(--muted-foreground);
            font-size: 0.86rem;
        }

        .chart-area {
            position: relative;
            width: 100%;
            height: 320px;
        }

        .chart-area.donut {
            height: 300px;
        }

        .ringkasan-table {
            min-width: 100%;
        }

        .ringkasan-table td:last-child {
            text-align: right;
            font-weight: 800;
            color: var(--foreground);
        }

        @media (max-width: 820px) {
            .statistik-grid {
                grid-template-columns: 1fr;
            }

            .chart-area,
            .chart-area.donut {
                height: 280px;
            }
        }
    </style>
</head>

<body>

<header class="hero-small">
    <h1>Statistik</h1>
    <p>Grafik ringkasan pesanan, pendapatan, dan layanan laundry</p>

    <div class="container-button">
        <a class="buttonx button-back" href="../../index.php">Kembali</a>
        <a class="buttonx" href="../pelanggan/daftar_pelanggan.php">Daftar Pelanggan</a>
        <a class="buttonx" href="../layanan/daftar_layanan.php">Daftar Layanan</a>
        <a class="buttonx" href="../pesanan/daftar_pesanan.php">Daftar Pesanan</a>
    </div>
</header>

<main>
    <div class="container">

        <div class="top-section">
            <div>
                <h2 class="judul-left">Dashboard Statistik Laundry</h2>
                <p class="deskripsi-left">
                    Menampilkan data penting dari transaksi laundry dalam bentuk tabel dan grafik.
                </p>
            </div>
        </div>

        <div class="statistik-container full">
            <div class="statistik-header">
                <h3>Ringkasan Data</h3>
                <p>Total data utama dari sistem pengelolaan laundry.</p>
            </div>

            <div class="content">
                <table class="ringkasan-table">
                    <tr>
                        <th>Keterangan</th>
                        <th>Total</th>
                    </tr>

                    <tr>
                        <td>Total Pelanggan</td>
                        <td><?php echo number_format($total_pelanggan, 0, ',', '.'); ?></td>
                    </tr>

                    <tr>
                        <td>Total Pesanan</td>
                        <td><?php echo number_format($total_pesanan, 0, ',', '.'); ?></td>
                    </tr>

                    <tr>
                        <td>Pesanan Diproses</td>
                        <td><?php echo number_format($pesanan_diproses, 0, ',', '.'); ?></td>
                    </tr>

                    <tr>
                        <td>Pesanan Selesai</td>
                        <td><?php echo number_format($pesanan_selesai, 0, ',', '.'); ?></td>
                    </tr>

                    <tr>
                        <td>Total Pendapatan</td>
                        <td>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></td>
                    </tr>

                    <tr>
                        <td>Total Berat Cucian</td>
                        <td><?php echo number_format($total_berat, 1, ',', '.'); ?> Kg</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="statistik-grid">

            <div class="statistik-container">
                <div class="statistik-header">
                    <h3>Status Pesanan</h3>
                    <p>Perbandingan jumlah pesanan berdasarkan status.</p>
                </div>

                <div class="chart-area donut">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="statistik-container">
                <div class="statistik-header">
                    <h3>Layanan Sering Dipilih</h3>
                    <p>Jumlah pemakaian setiap layanan laundry.</p>
                </div>

                <div class="chart-area">
                    <canvas id="layananChart"></canvas>
                </div>
            </div>

            <div class="statistik-container full">
                <div class="statistik-header">
                    <h3>Pendapatan per Layanan</h3>
                    <p>Total pendapatan berdasarkan jenis layanan.</p>
                </div>

                <div class="chart-area">
                    <canvas id="pendapatanChart"></canvas>
                </div>
            </div>

        </div>

    </div>
</main>

<script>
const statusLabels = <?php echo json_encode($status_labels); ?>;
const statusValues = <?php echo json_encode($status_values); ?>;

const layananLabels = <?php echo json_encode($layanan_labels); ?>;
const layananValues = <?php echo json_encode($layanan_values); ?>;

const pendapatanLabels = <?php echo json_encode($pendapatan_labels); ?>;
const pendapatanValues = <?php echo json_encode($pendapatan_values); ?>;

const warna = {
    hitam: '#18181b',
    abu: '#71717a',
    border: '#e4e4e7',
    kuning: '#facc15',
    hijau: '#22c55e',
    biru: '#3b82f6',
    orange: '#fb923c'
};

function formatRupiah(value) {
    return 'Rp ' + Number(value).toLocaleString('id-ID');
}

const opsiDasar = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            labels: {
                color: warna.abu,
                usePointStyle: true,
                boxWidth: 8,
                boxHeight: 8
            }
        }
    },
    scales: {
        x: {
            ticks: {
                color: warna.abu
            },
            grid: {
                color: warna.border
            }
        },
        y: {
            beginAtZero: true,
            ticks: {
                color: warna.abu
            },
            grid: {
                color: warna.border
            }
        }
    }
};

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: [
                warna.kuning,
                warna.hijau,
                warna.orange,
                warna.biru
            ],
            borderColor: '#ffffff',
            borderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: warna.abu,
                    usePointStyle: true,
                    boxWidth: 8,
                    boxHeight: 8
                }
            }
        }
    }
});

new Chart(document.getElementById('layananChart'), {
    type: 'bar',
    data: {
        labels: layananLabels,
        datasets: [{
            label: 'Jumlah Dipilih',
            data: layananValues,
            backgroundColor: warna.hitam,
            borderRadius: 6
        }]
    },
    options: opsiDasar
});

new Chart(document.getElementById('pendapatanChart'), {
    type: 'bar',
    data: {
        labels: pendapatanLabels,
        datasets: [{
            label: 'Pendapatan',
            data: pendapatanValues,
            backgroundColor: warna.hijau,
            borderRadius: 6
        }]
    },
    options: {
        ...opsiDasar,
        plugins: {
            ...opsiDasar.plugins,
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return formatRupiah(context.raw);
                    }
                }
            }
        },
        scales: {
            ...opsiDasar.scales,
            y: {
                ...opsiDasar.scales.y,
                ticks: {
                    color: warna.abu,
                    callback: function(value) {
                        return formatRupiah(value);
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>