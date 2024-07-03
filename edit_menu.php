<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    $query = "SELECT * FROM tabel_menu WHERE Id_Menu = '$id_menu'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $id_menu = $_POST['id_menu'];
    $id_kategori = $_POST['id_kategori'];
    $nama_menu = $_POST['nama_menu'];
    $harga_satuan = $_POST['harga_satuan'];
    $gambar_menu = $_FILES['gambar_menu']['name'];
    
    // Tentukan folder target untuk gambar
    $target_dir = "gambar/";
    $target_file = $target_dir . basename($gambar_menu);
    
    // Jika ada gambar baru yang diunggah
    if ($gambar_menu) {
        if (move_uploaded_file($_FILES['gambar_menu']['tmp_name'], $target_file)) {
            // Jika berhasil mengunggah gambar baru, gunakan gambar baru
            $query = "UPDATE tabel_menu SET Id_Kategori = '$id_kategori', Nama_Menu = '$nama_menu', Harga_Satuan = '$harga_satuan', Gambar_Menu = '$gambar_menu' WHERE Id_Menu = '$id_menu'";
        } else {
            echo "Gagal mengunggah gambar.";
        }
    } else {
        // Jika tidak ada gambar baru yang diunggah, gunakan gambar lama
        $gambar_menu_lama = $_POST['gambar_menu_lama'];
        $query = "UPDATE tabel_menu SET Id_Kategori = '$id_kategori', Nama_Menu = '$nama_menu', Harga_Satuan = '$harga_satuan', Gambar_Menu = '$gambar_menu_lama' WHERE Id_Menu = '$id_menu'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                alert('Menu berhasil diubah!');
                window.location.href = 'menu.php';
              </script>";
    } else {
        echo "Gagal mengubah menu: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Menu</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="idMenu" class="form-label">ID Menu</label>
                <input type="text" class="form-control" id="idMenu" name="id_menu" value="<?= $data['Id_Menu'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="idKategori" class="form-label">ID Kategori</label>
                <input type="text" class="form-control" id="idKategori" name="id_kategori" value="<?= $data['Id_Kategori'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="namaMenu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="namaMenu" name="nama_menu" value="<?= $data['Nama_Menu'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="hargaSatuan" class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="hargaSatuan" name="harga_satuan" value="<?= $data['Harga_Satuan'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambarMenu" class="form-label">Gambar Menu</label>
                <input type="file" class="form-control" id="gambarMenu" name="gambar_menu" accept="image/*">
                <input type="hidden" name="gambar_menu_lama" value="<?= $data['Gambar_Menu'] ?>">
                <img src="gambar/<?= $data['Gambar_Menu'] ?>" alt="<?= $data['Nama_Menu'] ?>" style="width: 100px; height: auto;">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Ubah</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
