<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            //  Login sukses → simpan session & redirect ke dashboard (tanpa alert)
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user'] = [


                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
            ];
            $_SESSION['success_message'] = "Berhasil login! Selamat datang, {$user['first_name']}!";

            $_SESSION['success_message'] = "Berhasil login! Selamat datang, {$user['first_name']}!";

            header("Location: dashboard.php");
            exit;
        } else {
            //  Password salah → tampilkan alert
            echo "<script>
                alert('Password salah!');
                window.history.back();
            </script>";
        }
    } else {
        //  Email tidak ditemukan → tampilkan alert
        echo "<script>
            alert('Email tidak ditemukan!');
            window.history.back();
        </script>";
    }
}
