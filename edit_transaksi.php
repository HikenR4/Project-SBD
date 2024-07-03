<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id_invoice = $_GET['id'];

    $headerQuery = "SELECT * FROM tabel_header_transaksi WHERE Id_Invoice = '$id_invoice'";
    $headerResult = mysqli_query($conn, $headerQuery);
    $headerData = mysqli_fetch_assoc($headerResult);

    $detailQuery = "SELECT * FROM tabel_detail_transaksi WHERE Id_Invoice = '$id_invoice'";
    $detailResult = mysqli_query($conn, $detailQuery);
    $details = [];
    while ($row = mysqli_fetch_assoc($detailResult)) {
        $details[] = $row;
    }

    $menuQuery = "SELECT Id_Menu, Nama_Menu FROM tabel_menu";
    $menuResult = mysqli_query($conn, $menuQuery);
    $menus = [];
    while ($menuRow = mysqli_fetch_assoc($menuResult)) {
        $menus[] = $menuRow;
    }
}

if (isset($_POST['submit'])) {
    $id_invoice = $_POST['id_invoice'];
    $date_inv = $_POST['date_inv'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_kasir = $_POST['id_kasir'];
    $menus = $_POST['menu'];
    $total_harga = 0;

    $conn->begin_transaction();

    try {
        $query1 = "UPDATE tabel_header_transaksi SET Date_Inv = '$date_inv', Id_Pelanggan = '$id_pelanggan', Id_Kasir = '$id_kasir' WHERE Id_Invoice = '$id_invoice'";
        $result1 = mysqli_query($conn, $query1);
        if (!$result1) {
            throw new Exception("Gagal memperbarui transaksi: " . mysqli_error($conn));
        }

        $query2 = "DELETE FROM tabel_detail_transaksi WHERE Id_Invoice = '$id_invoice'";
        $result2 = mysqli_query($conn, $query2);
        if (!$result2) {
            throw new Exception("Gagal menghapus detail transaksi: " . mysqli_error($conn));
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

            $query3 = "INSERT INTO tabel_detail_transaksi (Id_Invoice, Id_Menu, Jumlah) VALUES ('$id_invoice', '$id_menu', '$jumlah')";
            $result3 = mysqli_query($conn, $query3);
            if (!$result3) {
                throw new Exception("Gagal menambahkan detail transaksi: " . mysqli_error($conn));
            }
        }

        $query4 = "UPDATE tabel_header_transaksi SET Total_Harga = '$total_harga' WHERE Id_Invoice = '$id_invoice'";
        $result4 = mysqli_query($conn, $query4);
        if (!$result4) {
            throw new Exception("Gagal mengupdate total harga: " . mysqli_error($conn));
        }

        $conn->commit();
        echo "<script>
                alert('Transaksi berhasil diperbarui!');
                window.location.href = 'transaksi.php';
              </script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Transaksi</title>
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
    <div class="card">
      <div class="card-header bg-primary text-white">
        Edit Transaksi
      </div>
      <div class="card-body">
        <form method="POST">
          <input type="hidden" name="id_invoice" value="<?= $id_invoice ?>">
          <div class="mb-3">
            <label for="dateInv" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="dateInv" name="date_inv" value="<?= $headerData['Date_Inv'] ?>" required>
          </div>
          <div class="mb-3">
            <label for="idPelanggan" class="form-label">ID Pelanggan</label>
            <input type="text" class="form-control" id="idPelanggan" name="id_pelanggan" value="<?= $headerData['Id_Pelanggan'] ?>" required>
          </div>
          <div class="mb-3">
            <label for="idKasir" class="form-label">ID Kasir</label>
            <input type="text" class="form-control" id="idKasir" name="id_kasir" value="<?= $headerData['Id_Kasir'] ?>" required>
          </div>
          <div id="menu-container">
            <?php foreach ($details as $index => $detail): ?>
            <div class="menu-item mb-3">
              <label for="idMenu" class="form-label">Menu</label>
              <select class="form-select" name="menu[<?= $index ?>][id_menu]" required>
                <?php foreach ($menus as $menu): ?>
                  <option value="<?= $menu['Id_Menu'] ?>" <?= ($menu['Id_Menu'] == $detail['Id_Menu']) ? 'selected' : '' ?>><?= $menu['Nama_Menu'] ?></option>
                <?php endforeach; ?>
              </select>
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" class="form-control" name="menu[<?= $index ?>][jumlah]" value="<?= $detail['Jumlah'] ?>" required>
            </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn-secondary" id="addMenuButton">Tambah Menu</button>
          <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let menuCount = <?= count($details) ?>;
    document.getElementById('addMenuButton').addEventListener('click', function () {
      const menuContainer = document.getElementById('menu-container');
      const newMenuItem = document.createElement('div');
      newMenuItem.className = 'menu-item mb-3';
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
      body {
        background-image: none;
        background-color: #FFF6E9;
      }
    </style>
</body>
</html>
