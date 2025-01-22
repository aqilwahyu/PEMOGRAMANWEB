<?php
session_start(); // Memulai sesi

// Jika sudah login, arahkan ke halaman dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");  // Sesuaikan dengan halaman dashboard Anda
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Utama</title>

  <!-- Link ke Bootstrap dan Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome Icons -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradasi warna biru ungu */
      font-family: 'Arial', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }
    .form-label {
      font-size: 1.1rem;
      color: #555555;
    }
    .button-login {
      background-color: #2575fc; /* Warna biru cerah */
      color: white;
      font-size: 1.1rem;
      padding: 12px 20px;
      width: 100%;
      border-radius: 30px;
      border: none;
      cursor: pointer;
    }
    .alert {
      margin-bottom: 20px;
      font-size: 1rem;
      padding: 15px;
      border-radius: 10px;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
  </style>
</head>

<body>

  <!-- Container -->
  <div class="form-container">
    <div class="text-center mb-4">
      <h2 class="font-bold text-3xl text-gray-600">Selamat datang di Halaman Utama</h2>
      <p class="text-gray-600">Silakan login untuk melanjutkan ke halaman dashboard</p>
    </div>

    <!-- Button Login -->
    <form action="login.php" method="get">
      <button type="submit" class="button-login">Login</button>
    </form>
  </div>

</body>
</html>
