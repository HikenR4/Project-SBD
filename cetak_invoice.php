<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id_invoice = $_GET['id'];

    // Mengambil data header transaksi
    $query = "SELECT th.Id_Invoice, th.Date_Inv, tp.Pelanggan, tk.Nama_Kasir, th.Total_Harga
              FROM tabel_header_transaksi th
              LEFT JOIN tabel_pelanggan tp ON th.Id_Pelanggan = tp.Id_Pelanggan
              LEFT JOIN tabel_kasir tk ON th.Id_Kasir = tk.Id_Kasir
              WHERE th.Id_Invoice = '$id_invoice'";
    $result = mysqli_query($conn, $query);
    $header = mysqli_fetch_assoc($result);

    if (!$header) {
        die("ID Invoice tidak ditemukan.");
    }

    // Mengambil data detail transaksi
    $detailQuery = "SELECT td.Id_Menu, tm.Nama_Menu, tm.Harga_Satuan, td.Jumlah, (tm.Harga_Satuan * td.Jumlah) AS Subtotal
                    FROM tabel_detail_transaksi td
                    LEFT JOIN tabel_menu tm ON td.Id_Menu = tm.Id_Menu
                    WHERE td.Id_Invoice = '$id_invoice'";
    $detailResult = mysqli_query($conn, $detailQuery);
    $details = [];
    while ($row = mysqli_fetch_assoc($detailResult)) {
        $details[] = $row;
    }
} else {
    die("ID Invoice tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .print-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .print-button button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px #999;
        }

        .print-button button:hover {
            background-color: #45a049;
        }

        .print-button button:active {
            background-color: #45a049;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Invoice</h2>
                            </td>
                            <td>
                                Invoice #: <?= $header['Id_Invoice'] ?><br>
                                Tanggal: <?= $header['Date_Inv'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Nama Pelanggan: <?= $header['Pelanggan'] ?>
                            </td>
                            <td>
                                Kasir: <?= $header['Nama_Kasir'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Menu</td>
                <td>Harga Satuan</td>
                <td>Jumlah</td>
                <td>Subtotal</td>
            </tr>

            <?php foreach ($details as $detail): ?>
            <tr class="item">
                <td><?= $detail['Nama_Menu'] ?></td>
                <td>Rp <?= number_format($detail['Harga_Satuan'], 2) ?></td>
                <td><?= $detail['Jumlah'] ?></td>
                <td>Rp <?= number_format($detail['Subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>

            <tr class="total">
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>Rp <?= number_format($header['Total_Harga'], 2) ?></td>
            </tr>
        </table>
    </div>
    <div class="print-button">
        <button onclick="window.print()">Print Invoice</button>
    </div>
</body>
</html>
