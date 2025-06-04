<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $birth = $_POST['birth_date'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, birth_date, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first, $last, $birth, $email, $password);

    if ($stmt->execute()) {
        header("Location: landingPage.php?register=success");
    } else {
        echo "Gagal mendaftar: " . $stmt->error;
    }
}
?>
