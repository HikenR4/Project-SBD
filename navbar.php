<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Orange Cafe</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>
      .navbar-custom {
        background-color: #ff7f3e;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        margin-bottom: 20px;
      }
      .navbar-custom .navbar-brand {
        color: rgba(255, 255, 255, 0.8); /* Slightly darkened white */
        font-weight: bold; /* Slightly thicker text */
      }
      .navbar-custom .nav-link {
        color: rgba(255, 255, 255, 0.8); /* Slightly darkened white */
        font-weight: bold; /* Slightly thicker text */
      }
      .navbar-custom .nav-link:hover,
      .navbar-custom .nav-link.active {
        color: #ffffff; /* Pure white when hovered or active */
      }
      body {
        background-image: url("gambar/1.jpeg");
        background-size: cover; /* Menyesuaikan ukuran gambar agar menutupi seluruh body */
        background-repeat: no-repeat; /* Menghindari pengulangan gambar */
        background-attachment: fixed; /* Membuat gambar tetap pada posisinya saat halaman di-scroll */
        width: 100%;
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div class="anonymus">
      <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid d-flex justify-content-between">
          <a class="navbar-brand" href="#">Orange Cafe</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" href="index.php">Home</a>
              <a class="nav-link" href="menu.php">Pilihan Menu</a>
              <a class="nav-link" href="kasir.php">Kasir</a>
              <a class="nav-link" href="pelanggan.php">Pelanggan</a>
              <a class="nav-link" href="transaksi.php">Transaksi</a>
            </div>
          </div>
        </div>
      </nav>

      <div class="container">
        <!-- Isi halaman Anda di sini -->
      </div>

      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
      ></script>
    </div>
  </body>
</html>


