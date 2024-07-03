<?php
include('koneksi.php');

$query = "SELECT * FROM tabel_pelanggan ORDER BY Id_Pelanggan ASC";
$result = mysqli_query($conn, $query);

if (isset($_POST['input'])) {
  $ID_Pelanggan = $_POST['ID_Pelanggan'];
  $Nama_Pelanggan = $_POST['Nama_Pelanggan'];
  $query = "INSERT INTO `tabel_pelanggan` (`Id_Pelanggan`, `Pelanggan`) VALUES ('$ID_Pelanggan','$Nama_Pelanggan')";
  $result2 = mysqli_query($conn, $query);

  if ($result2) {
    echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = 'pelanggan.php';
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
    <title>Pelanggan</title>
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
        Tambah Pelanggan
      </button>

      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID Pelanggan</th>
            <th scope="col">Nama Pelanggan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($data = mysqli_fetch_assoc($result)): ?>
          <tr>
            <th scope="row"><?= $data['Id_Pelanggan']?></th>
            <td><?= $data['Pelanggan'] ?></td>
            <td>
              <a href="hapus_pelanggan.php?id=<?= $data['Id_Pelanggan']?>" class="btn btn-danger btn-sm">Hapus</a>
              <a href="edit_pelanggan.php?id=<?= $data['Id_Pelanggan']?>" class="btn btn-success btn-sm">Edit</a>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST">
              <div class="mb-3">
                <label for="idPelanggan" class="form-label">ID Pelanggan</label>
                <input type="text" class="form-control" id="idPelanggan" name="ID_Pelanggan" required>
              </div>
              <div class="mb-3">
                <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="namaPelanggan" name="Nama_Pelanggan" required>
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
