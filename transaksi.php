<?php
include('koneksi.php');

// Function to generate a new invoice ID
function generateInvoiceID($conn) {
    $query = "SELECT Id_Invoice FROM tabel_header_transaksi ORDER BY Id_Invoice DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $lastInvoice = mysqli_fetch_assoc($result);

    if ($lastInvoice) {
        $lastID = (int) substr($lastInvoice['Id_Invoice'], 3);
        $newID = $lastID + 1;
        return 'INV' . str_pad($newID, 2, '0', STR_PAD_LEFT);
    } else {
        return 'INV01';
    }
}

if (isset($_POST['submit'])) {
    $id_invoice = generateInvoiceID($conn);
    $date_inv = $_POST['date_inv'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_kasir = $_POST['id_kasir'];
    $menus = $_POST['menu'];
    $total_harga = 0;

    $conn->begin_transaction();

    try {
        $query1 = "INSERT INTO tabel_header_transaksi (Id_Invoice, Date_Inv, Id_Pelanggan, Id_Kasir) VALUES ('$id_invoice', '$date_inv', '$id_pelanggan', '$id_kasir')";
        $result1 = mysqli_query($conn, $query1);
        if (!$result1) {
            throw new Exception("Gagal menambahkan transaksi: " . mysqli_error($conn));
        }

        foreach ($menus as $menu) {
            $id_menu = $menu['id_menu'];
            $jumlah = $menu['jumlah'];

            $menuQuery = "SELECT Harga_Satuan FROM tabel_menu WHERE Id_Menu = '$id_menu'";
            $menuResult = mysqli_query($conn, $menuQuery);
            $menuData = mysqli_fetch_assoc($menuResult);
            $harga_satuan = $menuData['Harga_Satuan'];
            $subtotal = $harga_satuan * $jumlah;
            $total_harga += $subtotal;

            $query2 = "INSERT INTO tabel_detail_transaksi (Id_Invoice, Id_Menu, Jumlah) VALUES ('$id_invoice', '$id_menu', '$jumlah')";
            $result2 = mysqli_query($conn, $query2);
            if (!$result2) {
                throw new Exception("Gagal menambahkan detail transaksi: " . mysqli_error($conn));
            }
        }

        $query3 = "UPDATE tabel_header_transaksi SET Total_Harga = '$total_harga' WHERE Id_Invoice = '$id_invoice'";
        $result3 = mysqli_query($conn, $query3);
        if (!$result3) {
            throw new Exception("Gagal mengupdate total harga: " . mysqli_error($conn));
        }

        $conn->commit();
        echo "<script>
                alert('Transaksi berhasil ditambahkan!');
                window.location.href = 'transaksi.php';
              </script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
}

$query = "SELECT th.Id_Invoice, th.Date_Inv, tp.Pelanggan, tk.Nama_Kasir, th.Total_Harga
          FROM tabel_header_transaksi th
          LEFT JOIN tabel_detail_transaksi td ON th.Id_Invoice = td.Id_Invoice
          LEFT JOIN tabel_menu tm ON td.Id_Menu = tm.Id_Menu
          LEFT JOIN tabel_pelanggan tp ON th.Id_Pelanggan = tp.Id_Pelanggan
          LEFT JOIN tabel_kasir tk ON th.Id_Kasir = tk.Id_Kasir
          GROUP BY th.Id_Invoice, th.Date_Inv, tp.Pelanggan, tk.Nama_Kasir
          ORDER BY th.Id_Invoice ASC";
$result = mysqli_query($conn, $query);

$menuQuery = "SELECT Id_Menu, Nama_Menu FROM tabel_menu";
$menuResult = mysqli_query($conn, $menuQuery);
$menus = [];
while ($menuRow = mysqli_fetch_assoc($menuResult)) {
    $menus[] = $menuRow;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .table {
        margin-top: 20px;
    }
    .modal-header {
        background-color: #007bff;
        color: white;
    }
    .modal-footer {
        justify-content: space-between;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
  </style>
</head>
<body>
  <?php include("navbar.php"); ?>

  <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Tambah Transaksi
    </button>

    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID Invoice</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Pelanggan</th>
          <th scope="col">Kasir</th>
          <th scope="col">Total Harga</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($data = mysqli_fetch_assoc($result)): ?>
        <tr>
          <th scope="row"><?= $data['Id_Invoice']?></th>
          <td><?= $data['Date_Inv'] ?></td>
          <td><?= $data['Pelanggan'] ?></td>
          <td><?= $data['Nama_Kasir'] ?></td>
          <td><?= 'Rp ' . number_format($data['Total_Harga'], 2, ',', '.') ?></td>
          <td>
            <a href="hapus_transaksi.php?id=<?= $data['Id_Invoice']?>" class="btn btn-danger btn-sm">Hapus</a>
            <a href="edit_transaksi.php?id=<?= $data['Id_Invoice']?>" class="btn btn-success btn-sm">Edit</a>
            <a href="cetak_invoice.php?id=<?= $data['Id_Invoice']?>" class="btn btn-info btn-sm">Print</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST">
            <div class="mb-3">
              <label for="dateInv" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="dateInv" name="date_inv" required>
            </div>
            <div class="mb-3">
              <label for="idPelanggan" class="form-label">ID Pelanggan</label>
              <input type="text" class="form-control" id="idPelanggan" name="id_pelanggan" required>
            </div>
            <div class="mb-3">
              <label for="idKasir" class="form-label">ID Kasir</label>
              <input type="text" class="form-control" id="idKasir" name="id_kasir" required>
            </div>
            <div id="menu-container">
              <div class="menu-item mb-3">
                <label for="idMenu" class="form-label">Menu</label>
                <select class="form-select" name="menu[0][id_menu]" required>
                  <?php foreach ($menus as $menu): ?>
                    <option value="<?= $menu['Id_Menu'] ?>"><?= $menu['Nama_Menu'] ?></option>
                  <?php endforeach; ?>
                </select>
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="menu[0][jumlah]" required>
              </div>
            </div>
            <button type="button" class="btn btn-secondary" id="addMenuButton">Tambah Menu</button>
            <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let menuCount = 1;
    document.getElementById('addMenuButton').addEventListener('click', function () {
      const menuContainer = document.getElementById('menu-container');
      const newMenuItem = document.createElement('div');
      newMenuItem.classList.add('menu-item', 'mb-3');
      newMenuItem.innerHTML = `
        <label for="idMenu" class="form-label">Menu</label>
        <select class="form-select" name="menu[${menuCount}][id_menu]" required>
          <?php foreach ($menus as $menu): ?>
            <option value="<?= $menu['Id_Menu'] ?>"><?= $menu['Nama_Menu'] ?></option>
          <?php endforeach; ?>
        </select>
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" class="form-control" name="menu[${menuCount}][jumlah]" required>
      `;
      menuContainer.appendChild(newMenuItem);
      menuCount++;
    });
  </script>
<style>
    body{
      background-image: none;
      background-color: #FFF6E9;
    }
  </style> 
</body>
</html>
