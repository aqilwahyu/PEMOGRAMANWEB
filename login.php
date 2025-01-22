<?php
session_start();  // Memulai sesi

// Variabel untuk menampilkan pesan error atau sukses
$message = "";

// Cek apakah form login sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($password)) {
        $message = "Username dan Password harus diisi!";
    } else {
        // Tentukan kredensial admin default
        $validUsername = 'admin';
        $validPassword = 'admin123';

        // Periksa apakah username dan password yang dimasukkan adalah admin
        if ($username === $validUsername && $password === $validPassword) {
            // Set session jika login berhasil dengan kredensial admin
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;  // Menyimpan username pengguna
            $_SESSION['level'] = 'admin';  // Menyimpan level pengguna (admin)

            // Redirect ke halaman dashboard setelah login berhasil
            header('Location: dashboard.php');
            exit;
        }

        // Koneksi ke database
        require_once 'koneksi.php';  // Pastikan koneksi database sudah ada

        // Ambil data pengguna dari database berdasarkan username
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Periksa apakah username ditemukan dan password yang dimasukkan sesuai dengan password hash di database
            if ($user && password_verify($password, $user['password'])) {
                // Jika login berhasil, set session
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username'];  // Menyimpan username pengguna
                $_SESSION['level'] = $user['level'];  // Menyimpan level pengguna (admin atau user)

                // Redirect ke halaman dashboard setelah login berhasil
                header('Location: dashboard.php');
                exit;
            } else {
                // Jika login gagal
                $message = "Username atau password salah!";
            }
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
    <title>Login Admin</title>

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
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-label {
            font-size: 1.1rem;
            color: #555555;
        }

        .input-group input {
            border-radius: 30px;
            padding-left: 35px;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .button-login:hover {
            transform: scale(1.05);
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
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

        /* Icon styling */
        .icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
        }

        .input-group {
            position: relative;
        }

    </style>
</head>

<body>

    <!-- Container -->
    <div class="form-container">
        <div class="text-center mb-4">
            <h2 class="font-bold text-3xl text-gray-600">Login Admin</h2>
            <p class="text-gray-600">Masukkan username dan password Anda untuk login</p>
        </div>

        <!-- Tampilkan pesan error atau sukses -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo strpos($message, 'salah') !== false ? 'danger' : 'success'; ?> text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="login.php" method="post">
            <!-- Username Input -->
            <div class="mb-3 input-group">
                <i class="fas fa-user icon"></i> <!-- Menambahkan ikon user -->
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
            </div>

            <!-- Password Input -->
            <div class="mb-3 input-group">
                <i class="fas fa-lock icon"></i> <!-- Menambahkan ikon lock -->
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>

            <!-- Button Login -->
            <button type="submit" class="button-login">Login</button>
        </form>
    </div>

</body>

</html>
