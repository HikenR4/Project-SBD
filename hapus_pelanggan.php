<?php
include('koneksi.php');

if (isset($_GET['id'])) {
  $id_kasir = $_GET['id'];
  $query = "DELETE FROM tabel_pelanggan WHERE Id_Pelanggan = '$id_kasir'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'pelanggan.php'; // Ganti 'index.php' dengan nama file utama Anda
          </script>";
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "ID kasir tidak ditemukan.";
}
?>
