<?php
include('koneksi.php');

$query = "SELECT * FROM tabel_kasir ORDER BY Id_Kasir ASC";
$result = mysqli_query($conn, $query);

if (isset($_POST['input'])) {
  $ID_Kasir = $_POST['ID_Kasir'];
  $Nama = $_POST['Nama_kasir'];
  $query = "INSERT INTO `tabel_kasir` (`Id_Kasir`, `Nama_Kasir`) VALUES ('$ID_Kasir','$Nama')";
  $result2 = mysqli_query($conn, $query);

  if ($result2) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'kasir.php'; 
          </script>";
  } else {
    echo "Gagal menambahkan data: " . mysqli_error($conn);
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir</title>
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
        Tambah Kasir
      </button>

      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID Kasir</th>
            <th scope="col">Nama Kasir</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($data = mysqli_fetch_assoc($result)): ?>
          <tr>
            <th scope="row"><?= $data['Id_Kasir']?></th>
            <td><?= $data['Nama_Kasir'] ?></td>
            <td>
              <a href="hapus_kasir.php?id=<?= $data['Id_Kasir']?>" class="btn btn-danger btn-sm">Hapus</a>
              <a href="edit_kasir.php?id=<?= $data['Id_Kasir']?>" class="btn btn-success btn-sm">Edit</a>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Kasir</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST">
              <div class="mb-3">
                <label for="idKasir" class="form-label">ID Kasir</label>
                <input type="text" class="form-control" id="idKasir" name="ID_Kasir" required>
              </div>
              <div class="mb-3">
                <label for="namaKasir" class="form-label">Nama Kasir</label>
                <input type="text" class="form-control" id="namaKasir" name="Nama_kasir" required>
              </div>
              <button type="submit" class="btn btn-primary" name="input">Tambah</button>
            </form>
          </div>
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
