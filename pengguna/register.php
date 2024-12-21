<?php
session_start();
include('../db.php');  // Ganti koneksi.php dengan db.php

if (isset($_POST['register'])) {
    $nama_pengguna = $_POST['nama_pengguna'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';  // Set role otomatis sebagai user

    // Cek apakah email sudah terdaftar
    $query = "SELECT * FROM pengguna WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan pengguna baru
        $query = "INSERT INTO pengguna (Nama_Pengguna, Email, Password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nama_pengguna, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            // Ambil data pengguna yang baru saja didaftarkan
            $user_id = $stmt->insert_id;  // ID pengguna yang baru saja didaftarkan

            // Simpan data pengguna ke session untuk login otomatis
            $_SESSION['ID_Pengguna'] = $user_id;
            $_SESSION['Nama_Pengguna'] = $nama_pengguna;
            $_SESSION['Email'] = $email;
            $_SESSION['role'] = $role;

            // Berikan pesan sukses
            $success = "Pendaftaran berhasil! Anda akan diarahkan ke dashboard.";

            // Redirect ke dashboard pengguna setelah 3 detik
            header("refresh:3;url=../user_dashboard.php");
        } else {
            $error = "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Daftar Pengguna Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-danger' role='alert'>$error</div>";
                        }
                        if (isset($success)) {
                            echo "<div class='alert alert-success' role='alert'>$success</div>";
                        }
                        ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Role disembunyikan dan sudah di-set otomatis -->
                            <input type="hidden" name="role" value="user">

                            <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>Sudah memiliki akun? <a href="login.php">Login sekarang</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
