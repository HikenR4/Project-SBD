<?php
include('koneksi.php');

function formatRupiah($number){
    return 'Rp ' . number_format($number, 0, ',', '.');
}

$query = "SELECT * FROM tabel_menu ORDER BY Id_Menu ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}

if (isset($_POST['submit'])) {
  $id_menu = $_POST['id_menu'];
  $id_kategori = $_POST['id_kategori'];
  $nama_menu = $_POST['nama_menu'];
  $harga_satuan = $_POST['harga_satuan'];
  $gambar_menu = $_FILES['gambar_menu']['name'];
  $target_dir = "gambar/";
  
  // Buat folder jika belum ada
  if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
  }
  
  $target_file = $target_dir . basename($gambar_menu);

  if (move_uploaded_file($_FILES['gambar_menu']['tmp_name'], $target_file)) {
    $query = "INSERT INTO tabel_menu (Id_Menu, Id_Kategori, Nama_Menu, Harga_Satuan, Gambar_Menu) VALUES ('$id_menu', '$id_kategori', '$nama_menu', '$harga_satuan', '$gambar_menu')";
    $result2 = mysqli_query($conn, $query);

    if ($result2) {
      echo "<script>
              alert('Menu berhasil ditambahkan!');
              window.location.href = 'menu.php'; 
            </script>";
    } else {
      echo "Gagal menambahkan menu: " . mysqli_error($conn);
    }
  } else {
    echo "Gagal mengunggah gambar.";
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu</title>
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
    .menu-img {
        width: 250px; /* Ganti nilai ini sesuai kebutuhan Anda */
        height: auto;
    }
  </style>
</head>
<body>
  <?php include("navbar.php"); ?>

  <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Tambah Menu
    </button>

    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID_Menu</th>
          <th scope="col">ID_Kategori</th>
          <th scope="col">Nama Menu</th>
          <th scope="col">Harga Satuan</th>
          <th scope="col">Gambar</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result): ?>
          <?php while($data = mysqli_fetch_assoc($result)): ?>
          <tr>
            <th scope="row"><?= $data['Id_Menu']?></th>
            <td><?= $data['Id_Kategori'] ?></td>
            <td><?= $data['Nama_Menu'] ?></td>
            <td><?= formatRupiah($data['Harga_Satuan']) ?></td>
            <td><img src="gambar/<?= $data['Gambar_Menu'] ?>" class="menu-img" alt="<?= $data['Nama_Menu'] ?>"></td>
            <td>
              <a href="hapus_menu.php?id=<?= $data['Id_Menu']?>" class="btn btn-danger btn-sm">Hapus</a>
              <a href="edit_menu.php?id=<?= $data['Id_Menu']?>" class="btn btn-success btn-sm">Edit</a>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">Tidak ada data.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="idMenu" class="form-label">ID Menu</label>
              <input type="text" class="form-control" id="idMenu" name="id_menu" required>
            </div>
            <div class="mb-3">
              <label for="idKategori" class="form-label">ID Kategori</label>
              <input type="text" class="form-control" id="idKategori" name="id_kategori" required>
            </div>
            <div class="mb-3">
              <label for="namaMenu" class="form-label">Nama Menu</label>
              <input type="text" class="form-control" id="namaMenu" name="nama_menu" required>
            </div>
            <div class="mb-3">
              <label for="hargaSatuan" class="form-label">Harga Satuan</label>
              <input type="number" class="form-control" id="hargaSatuan" name="harga_satuan" required>
            </div>
            <div class="mb-3">
              <label for="gambarMenu" class="form-label">Gambar Menu</label>
              <input type="file" class="form-control" id="gambarMenu" name="gambar_menu" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
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
