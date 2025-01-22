<?php
// Menyertakan file koneksi.php
include 'koneksi.php';

// Variabel untuk menampilkan pesan error atau sukses
$message = "";

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $level = trim($_POST['level']);  // Misalnya: 'admin' atau 'user'

    // Validasi input
    if (empty($username) || empty($password) || empty($level)) {
        $message = "Semua kolom harus diisi!";
    } else {
        // Menghasilkan hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Koneksi ke database dan masukkan data ke tabel users
        try {
            // Query untuk menyimpan user ke database
            $stmt = $pdo->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $level]);

            $message = "User berhasil dibuat!";
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Pengguna Baru</title>
</head>
<body>

  <h2>Buat Pengguna Baru</h2>

  <!-- Tampilkan pesan error atau sukses -->
  <?php if ($message): ?>
    <div>
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <!-- Form untuk membuat pengguna baru -->
  <form action="create_user.php" method="post">
    <div>
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
    </div>

    <div>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
    </div>

    <div>
      <label for="level">Level:</label>
      <select name="level" id="level" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>

    <div>
      <button type="submit">Buat Pengguna</button>
    </div>
  </form>

</body>
</html>
