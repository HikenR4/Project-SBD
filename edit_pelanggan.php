<?php
include('koneksi.php');

if (isset($_GET['id'])) {
  $id_pelanggan = $_GET['id'];
  $query = "SELECT * FROM tabel_pelanggan WHERE Id_Pelanggan = '$id_pelanggan'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_assoc($result);

  if (isset($_POST['update'])) {
    $nama_pelanggan = $_POST['Nama_Pelanggan'];
    $query_update = "UPDATE tabel_pelanggan SET Pelanggan = '$nama_pelanggan' WHERE Id_Pelanggan = '$id_pelanggan'";
    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
      echo "<script>
              alert('Data berhasil diupdate!');
              window.location.href = 'pelanggan.php';
            </script>";
    } else {
      echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
  }
} else {
  echo "ID pelanggan tidak ditemukan.";
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Pelanggan</title>
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
        Edit Pelanggan
      </div>
      <div class="card-body">
        <form method="POST">
          <div class="mb-3">
            <label for="idPelanggan" class="form-label">ID Pelanggan</label>
            <input type="text" class="form-control" id="idPelanggan" name="ID_Pelanggan" value="<?= $data['Id_Pelanggan'] ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="namaPelanggan" name="Nama_Pelanggan" value="<?= $data['Pelanggan'] ?>" required>
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
