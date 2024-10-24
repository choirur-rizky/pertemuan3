<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pencatatan Data Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sistem Pencatatan Data Penjualan</h1>
    <form method="POST">
        <label for="nama_produk">Nama Produk:</label>
        <input type="text" name="nama_produk" required placeholder="Masukkan nama produk"><br><br>

        <label for="harga">Harga Per Produk:</label>
        <input type="number" name="harga" required placeholder="Masukkan harga" min="0"><br><br>

        <label for="jumlah">Jumlah Terjual:</label>
        <input type="number" name="jumlah" required placeholder="Masukkan jumlah" min="1"><br><br>

        <button type="submit">Tambah Penjualan</button>
    </form>

    <?php
    session_start();

    // Inisialisasi array penjualan
    if (!isset($_SESSION['penjualan'])) {
        $_SESSION['penjualan'] = [];
    }

    // Menangani input form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $jumlah = $_POST['jumlah'];

        // Menyimpan data transaksi dalam array asosiatif
        $transaksi = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'total' => $harga * $jumlah,
        ];

        $_SESSION['penjualan'][] = $transaksi;
    }

    // Fungsi untuk menghitung total penjualan
    function hitungTotalPenjualan($transaksi) {
        $total_penjualan = 0;
        foreach ($transaksi as $item) {
            $total_penjualan += $item['total'];
        }
        return $total_penjualan;
    }
    ?>

    <h2>Laporan Penjualan:</h2>
    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Harga Per Produk</th>
            <th>Jumlah Terjual</th>
            <th>Total</th>
        </tr>
        <?php
        // Menampilkan laporan penjualan
        $total_jumlah = 0;
        $total_penjualan = 0;

        foreach ($_SESSION['penjualan'] as $item) {
            echo "<tr>";
            echo "<td>{$item['nama_produk']}</td>";
            echo "<td>" . number_format($item['harga'], 2) . "</td>";
            echo "<td>{$item['jumlah']}</td>";
            echo "<td>" . number_format($item['total'], 2) . "</td>";
            echo "</tr>";

            $total_jumlah += $item['jumlah'];
            $total_penjualan += $item['total'];
        }
        ?>
        <tr>
            <td><strong>Total Penjualan</strong></td>
            <td></td>
            <td><strong><?php echo $total_jumlah; ?></strong></td>
            <td><strong><?php echo number_format($total_penjualan, 2); ?></strong></td>
        </tr>
    </table>
</body>
</html>
