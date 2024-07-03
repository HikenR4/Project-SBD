<?php
include('koneksi.php');

if (isset($_GET['id'])) {
  $id_kasir = $_GET['id'];
  $query = "SELECT * FROM tabel_kasir WHERE Id_Kasir = '$id_kasir'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_assoc($result);

  if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
  }
} else {
  echo "ID kasir tidak ditemukan.";
  exit;
}

if (isset($_POST['update'])) {
  $Nama = $_POST['Nama_kasir'];
  $query = "UPDATE tabel_kasir SET Nama_Kasir = '$Nama' WHERE Id_Kasir = '$id_kasir'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo "<script>
            alert('Data berhasil diperbarui!');
            window.location.href = 'kasir.php';
          </script>";
  } else {
    echo "Gagal memperbarui data: " . mysqli_error($conn);
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Kasir</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .container {
        margin-top: 50px;
    }
    .card-header {
        background-color: #007bff;
        color: white;
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

  <div class="container">
    <div class="card">
      <div class="card-header bg-primary text-white">
        Edit Kasir
      </div>
      <div class="card-body">
        <form method="POST">
          <div class="mb-3">
            <label for="idKasir" class="form-label">ID Kasir</label>
            <input type="text" class="form-control" id="idKasir" name="ID_Kasir" value="<?= $data['Id_Kasir']?>" readonly>
          </div>
          <div class="mb-3">
            <label for="namaKasir" class="form-label">Nama Kasir</label>
            <input type="text" class="form-control" id="namaKasir" name="Nama_kasir" value="<?= $data['Nama_Kasir']?>" required>
          </div>
          <button type="submit" class="btn btn-primary" name="update">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
      body {
        background-image: none;
        background-color: #FFF6E9;
      }
    </style>
</body>
</html>
