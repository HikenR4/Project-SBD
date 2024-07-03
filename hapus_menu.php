<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    // Hapus entri terkait di tabel_detail_transaksi
    $query_detail = "DELETE FROM tabel_detail_transaksi WHERE Id_Menu = '$id_menu'";
    $result_detail = mysqli_query($conn, $query_detail);

    if ($result_detail) {
        // Jika berhasil menghapus entri terkait, hapus entri di tabel_menu
        $query_menu = "DELETE FROM tabel_menu WHERE Id_Menu = '$id_menu'";
        $result_menu = mysqli_query($conn, $query_menu);

        if ($result_menu) {
            echo "<script>
                    alert('Menu berhasil dihapus!');
                    window.location.href = 'menu.php';
                  </script>";
        } else {
            echo "Gagal menghapus menu: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal menghapus detail transaksi: " . mysqli_error($conn);
    }
}
?>
