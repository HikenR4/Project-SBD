<?php
include('koneksi.php');

if (isset($_GET['id'])) {
  $id_invoice = $_GET['id'];

  // Hapus baris terkait di tabel_detail_transaksi
  $queryDetail = "DELETE FROM tabel_detail_transaksi WHERE Id_Invoice = '$id_invoice'";
  $resultDetail = mysqli_query($conn, $queryDetail);

  if ($resultDetail) {
    // Setelah baris terkait dihapus, hapus baris di tabel_header_transaksi
    $queryHeader = "DELETE FROM tabel_header_transaksi WHERE Id_Invoice = '$id_invoice'";
    $resultHeader = mysqli_query($conn, $queryHeader);

    if ($resultHeader) {
      echo "<script>
              alert('Transaksi berhasil dihapus!');
              window.location.href = 'transaksi.php';
            </script>";
    } else {
      echo "Gagal menghapus transaksi: " . mysqli_error($conn);
    }
  } else {
    echo "Gagal menghapus detail transaksi: " . mysqli_error($conn);
  }
} else {
  echo "ID invoice tidak ditemukan.";
}
?>
